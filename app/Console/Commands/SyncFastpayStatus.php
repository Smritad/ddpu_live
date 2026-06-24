<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;
use App\Models\FileDetail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncFastpayStatus extends Command
{
    protected $signature   = 'sync:fastpay-status';
    protected $description = 'Sync FastPay transaction status and total amount to local DB';

    public function handle()
    {
        Log::info('FastPay Status Sync Started');
        $this->info('Starting FastPay sync...');

        // ── Strategy A: files WITH fastpay_file_id ────────────────────────
        $filesWithId = File::whereNotNull('fastpay_file_id')
            ->where('status', 'uploaded')
            ->get();

        // ── Strategy B: uploaded files WITHOUT fastpay_file_id ───────────
        // These were uploaded before we started storing the FileId.
        // Try to match by filename from the FastPay file list.
        $filesWithoutId = File::whereNull('fastpay_file_id')
            ->where('status', 'uploaded')
            ->get();

        if ($filesWithId->isEmpty() && $filesWithoutId->isEmpty()) {
            Log::info('No uploaded files found for syncing');
            $this->warn('No files to sync.');
            return;
        }

        // ── Fetch full FastPay file list once (for strategy B matching) ──
        $fastpayFileList = [];
        try {
            $listResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Bearer-Token' => config('services.fastpay.token'),
                    'Accept'       => 'application/json',
                ])
                ->timeout(30)
                ->get(config('services.fastpay.url') . '/api/Files');

            $listData        = $listResponse->json();
            $fastpayFileList = $listData['Data'] ?? [];

            Log::info('FastPay file list fetched', ['count' => count($fastpayFileList)]);
        } catch (\Exception $e) {
            Log::warning('Could not fetch FastPay file list: ' . $e->getMessage());
        }

        // ── Backfill fastpay_file_id for old records ──────────────────────
        foreach ($filesWithoutId as $file) {
            if (empty($fastpayFileList)) continue;

            foreach ($fastpayFileList as $fpFile) {
                $fpName = $fpFile['Filename'] ?? $fpFile['InternalFilename'] ?? '';
                if (
                    str_contains($fpName, $file->fastpay_filename ?? '') ||
                    str_contains($fpName, $file->file_name ?? '')
                ) {
                    $foundId = $fpFile['FileId'] ?? $fpFile['Id'] ?? null;
                    if ($foundId) {
                        $file->fastpay_file_id = $foundId;
                        $file->save();
                        Log::info('Backfilled fastpay_file_id', [
                            'file_id'         => $file->id,
                            'fastpay_file_id' => $foundId,
                        ]);
                        // Move to Strategy A pool
                        $filesWithId->push($file);
                        break;
                    }
                }
            }
        }

        if ($filesWithId->isEmpty()) {
            Log::warning('No FastPay FileIds available — cannot sync transaction statuses. Check FastPay GET /api/Files response structure.');
            $this->warn('No FastPay FileIds found. Sync cannot proceed.');
            return;
        }

        $totalUpdated = 0;

        // ── Sync each file's transactions ──────────────────────────────────
        foreach ($filesWithId as $file) {
            try {
                $this->line("Syncing file ID {$file->id} (FastPay ID: {$file->fastpay_file_id})");

                Log::info('Syncing file', [
                    'file_id'         => $file->id,
                    'fastpay_file_id' => $file->fastpay_file_id,
                ]);

                $response = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        'Bearer-Token' => config('services.fastpay.token'),
                        'Accept'       => 'application/json',
                    ])
                    ->timeout(60)
                    ->get(config('services.fastpay.url') . '/api/Transactions?FileId=' . $file->fastpay_file_id);

                if (!$response->successful()) {
                    Log::error('FastPay Transactions API failed', [
                        'file_id'  => $file->id,
                        'status'   => $response->status(),
                        'response' => $response->body(),
                    ]);
                    $this->error("  ✗ API failed for file {$file->id}");
                    continue;
                }

                $data = $response->json();

                Log::info('FastPay transactions response', [
                    'file_id'  => $file->id,
                    'response' => $data,
                ]);

                if (empty($data['Data'])) {
                    Log::info('No transaction data yet', ['file_id' => $file->id]);
                    $this->warn("  ⏳ No transactions yet for file {$file->id}");
                    continue;
                }

                $updatedCount = 0;
                $runningTotal = 0;

                foreach ($data['Data'] as $txn) {
                    $ddRef  = $txn['DdReference'] ?? null;
                    $status = strtolower($txn['Status'] ?? 'processing');
                    $amount = (float) ($txn['Amount'] ?? 0);

                    if (!$ddRef) continue;

                    $updated = FileDetail::where('file_id', $file->id)
                        ->where('dd_reference', $ddRef)
                        ->update(['status' => $status]);

                    if ($updated) {
                        $updatedCount++;
                        $runningTotal += $amount;
                    }
                }

                // Update total_amount from FastPay's own transaction data
                if ($runningTotal > 0) {
                    $file->total_amount = $runningTotal;
                    $file->save();
                    Log::info('Updated total_amount from FastPay', [
                        'file_id'      => $file->id,
                        'total_amount' => $runningTotal,
                    ]);
                }

                $totalUpdated += $updatedCount;

                Log::info('File sync completed', [
                    'file_id'         => $file->id,
                    'updated_records' => $updatedCount,
                    'total_amount'    => $runningTotal,
                ]);

                $this->info("  ✓ File {$file->id}: {$updatedCount} records synced, £{$runningTotal}");

            } catch (\Exception $e) {
                Log::error('Sync failed for file', [
                    'file_id' => $file->id,
                    'error'   => $e->getMessage(),
                ]);
                $this->error("  ✗ Failed: " . $e->getMessage());
            }
        }

        Log::info('FastPay Status Sync Finished', ['total_records_updated' => $totalUpdated]);
        $this->info("Sync complete. {$totalUpdated} records updated.");
    }
}