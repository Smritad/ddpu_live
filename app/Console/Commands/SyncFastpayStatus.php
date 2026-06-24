<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;
use App\Models\FileDetail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SyncFastpayStatus extends Command
{
    protected $signature   = 'sync:fastpay-status';
    protected $description = 'Sync FastPay collection results (paid/failed) from the remittance report into local DB';

    /*
     | WHY THE REMITTANCE REPORT?
     | FastPay's test/live API does NOT expose a working way to query a file's
     | transactions:
     |   - GET /api/Files            -> 405 (POST only)
     |   - GET /api/Transactions     -> 500 (ambiguous route on FastPay's side)
     | The only working read endpoint is the remittance report:
     |   - GET /api/files/{yyyy}/{mm}/{dd}  -> CSV with a per-row Status column
     | So we pull that report for each file's collection date (+ a few days, since
     | remittance lands around/after the collection date) and update statuses by
     | matching the Direct Debit Reference.
    */

    /** How many days from the collection date to scan for the remittance report. */
    private const REMITTANCE_WINDOW_DAYS = 6;

    public function handle()
    {
        Log::info('FastPay Status Sync started (remittance mode)');
        $this->info('Starting FastPay remittance sync...');

        // Only files we actually uploaded and that have a collection date to anchor on.
        $files = File::where('status', 'uploaded')
            ->whereNotNull('collection_date')
            ->get();

        if ($files->isEmpty()) {
            $this->warn('No uploaded files to sync.');
            Log::info('FastPay sync: no uploaded files.');
            return self::SUCCESS;
        }

        // Collect every remittance date we need (collection_date .. +N days), de-duplicated.
        $dates = [];
        foreach ($files as $file) {
            $start = Carbon::parse($file->collection_date);
            for ($i = 0; $i <= self::REMITTANCE_WINDOW_DAYS; $i++) {
                $dates[$start->copy()->addDays($i)->format('Y/m/d')] = true;
            }
        }

        // Fetch + parse each report once → map of dd_reference => ['status','amount'].
        $remittance = [];
        foreach (array_keys($dates) as $date) {
            foreach ($this->fetchRemittance($date) as $ref => $info) {
                $remittance[$ref] = $info; // later/more-specific report wins
            }
        }

        if (empty($remittance)) {
            $this->warn('No remittance rows yet — collections may not be processed by FastPay.');
            Log::info('FastPay sync: no remittance rows found yet.');
            return self::SUCCESS;
        }

        $totalUpdated = 0;

        foreach ($files as $file) {
            $details = FileDetail::where('file_id', $file->id)->get();
            $updated = 0;

            foreach ($details as $detail) {
                $ref = $detail->dd_reference;
                if (!$ref || !isset($remittance[$ref])) {
                    continue;
                }

                $detail->status = $remittance[$ref]['status'];
                $detail->save();
                $updated++;
            }

            if ($updated > 0) {
                $totalUpdated += $updated;
                $this->info("  ✓ File {$file->id}: {$updated} row(s) updated");
                Log::info('FastPay sync: file updated', ['file_id' => $file->id, 'rows' => $updated]);
            }
        }

        $this->info("Sync complete. {$totalUpdated} record(s) updated.");
        Log::info('FastPay Status Sync finished', ['updated' => $totalUpdated]);

        return self::SUCCESS;
    }

    /**
     * Fetch one remittance report and parse it.
     *
     * @return array<string, array{status:string, amount:float}> keyed by DD reference
     */
    private function fetchRemittance(string $date): array
    {
        try {
            $resp = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Bearer-Token' => config('services.fastpay.token'),
                    'Accept'       => 'application/json',
                ])
                ->timeout(40)
                ->get(rtrim(config('services.fastpay.url'), '/') . '/api/files/' . $date);

            if (!$resp->successful()) {
                Log::warning('Remittance fetch failed', ['date' => $date, 'http' => $resp->status()]);
                return [];
            }

            return $this->parseRemittance($resp->body());
        } catch (\Throwable $e) {
            Log::warning('Remittance fetch error', ['date' => $date, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Parse the remittance CSV.
     * Columns: 0 DD Reference | 1 Sortcode | 2 Account No | 3 Account Name |
     *          4 Amount | 5 BacsCode | 6 Status | 7 Submission Date | 8 Initial | 9 Forename | 10 Surname
     * Section labels ("Collections included..." / "Failed collections...") are used
     * as a fallback result when a row's own Status column is blank.
     *
     * @return array<string, array{status:string, amount:float}>
     */
    private function parseRemittance(string $body): array
    {
        $out  = [];
        $body = preg_replace('/^\xEF\xBB\xBF/', '', $body); // strip UTF-8 BOM
        $lines = preg_split('/\r\n|\r|\n/', $body);
        $section = null; // 'paid' | 'failed' | null

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            // Section markers
            if (stripos($line, 'Collections included') !== false) { $section = 'paid';   continue; }
            if (stripos($line, 'Failed collections')   !== false) { $section = 'failed'; continue; }
            if (stripos($line, 'Any other deductions')  !== false) { $section = null;    continue; }

            $cols = str_getcsv($line);
            $ref  = trim($cols[0] ?? '');

            // Skip the header row and any line without a usable data shape.
            if ($ref === '' || strcasecmp($ref, 'Direct Debit Reference') === 0) {
                continue;
            }
            if (count($cols) < 7) {
                continue;
            }

            $rowStatus = strtolower(trim($cols[6] ?? ''));
            if ($rowStatus === '') {
                $rowStatus = $section ?? 'processing';
            }

            $out[$ref] = [
                'status' => $rowStatus,
                'amount' => (float) ($cols[4] ?? 0),
            ];
        }

        return $out;
    }
}
