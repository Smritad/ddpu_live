<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\File;
use App\Models\FileDetail;
use App\Imports\FileDataImport;
use App\Exports\FileDataExport;

class FilesDetailsController extends Controller
{
    public function index(Request $request)
    {
        $query = File::latest();

        // Period filter (from-to date)
        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');

        if ($fromDate) {
            $query->whereDate('uploaded_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('uploaded_date', '<=', $toDate);
        }

        $files = $query->get();

        return view('backend.files.index', compact('files', 'fromDate', 'toDate'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'            => 'required|mimes:xlsx,xls,csv,ods,xml,txt|max:10240',
            'notes'           => 'nullable|string|max:255',
            'collection_date' => 'required|date',
        ]);

        $uploadedFile    = $request->file('file');
        $originalName    = $uploadedFile->getClientOriginalName();
        $collectionDate  = $request->collection_date;
        $notes           = $request->notes;

        $submissionDate = strtoupper(Carbon::parse($collectionDate)->format('d/M/Y'));
        $uploadDate     = strtoupper(now()->format('d/M/Y'));

        $fileRecord = File::create([
            'file_name'       => $originalName,
            'collection_date' => $collectionDate,
            'uploaded_date'   => now(),
            'notes'           => $notes,
            'status'          => 'pending',
        ]);

        try {
            Log::info('FastPay + Local Import started', [
                'file_id'         => $fileRecord->id,
                'file_name'       => $originalName,
            ]);

            $fileContent   = file_get_contents($uploadedFile->getRealPath());
            $base64Content = base64_encode($fileContent);

            $payload = [
                "MessageControl" => ["Version" => "1.0"],
                "Data" => [
                    "ClientID"         => 0,
                    "Filename"         => $originalName,
                    "InternalFilename" => $originalName,
                    "FileContent"      => $base64Content,
                    "SubmissionDate"   => $submissionDate,
                    "UploadDate"       => $uploadDate,
                    "FileId"           => 0,
                    "Status"           => 0,
                    "TotalAmount"      => 0,
                    "Notes"            => $notes ?? null,
                    "StatusName"       => "",
                ]
            ];

            $fastpayResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Bearer-Token' => config('services.fastpay.token'),
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->timeout(60)
                ->post(config('services.fastpay.url') . '/api/Files', $payload);

            $responseData = $fastpayResponse->json();

            if (!$fastpayResponse->successful() || ($responseData['MessageControl']['Status'] ?? 'Error') !== 'Success') {
                throw new \Exception("FastPay upload failed: " . json_encode($responseData));
            }

            $storedPath = $uploadedFile->store('uploads/fastpay/' . now()->format('Y/m'), 'local');

            Excel::import(new FileDataImport($fileRecord->id), $uploadedFile);

            $totalAmount = FileDetail::where('file_id', $fileRecord->id)->sum('amount');
            $rowCount    = FileDetail::where('file_id', $fileRecord->id)->count();

            $fileRecord->update([
                'file_path'        => $storedPath,
                'total_amount'     => $totalAmount,
                'fastpay_response' => json_encode($responseData),
                'status'           => 'uploaded',
            ]);

            return redirect()->route('files.index')
                ->with('success', "File processed: {$rowCount} records imported, £" . number_format($totalAmount, 2) . " total – uploaded to FastPay");

        } catch (\Exception $e) {
            if (isset($storedPath) && Storage::disk('local')->exists($storedPath)) {
                Storage::disk('local')->delete($storedPath);
            }
            FileDetail::where('file_id', $fileRecord->id)->delete();
            $fileRecord->update(['status' => 'failed', 'fastpay_response' => $e->getMessage()]);
            Log::error('Import + FastPay failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Processing failed: ' . $e->getMessage());
        }
    }

    public function export($id)
    {
        $file = File::findOrFail($id);

        return Excel::download(new class($file->id) implements FromCollection, WithHeadings {
            private $fileId;

            public function __construct($fileId)
            {
                $this->fileId = $fileId;
            }

            public function collection()
            {
                return FileDetail::where('file_id', $this->fileId)
                    ->get()
                    ->map(function ($row) {
                        return [
                            $row->dd_reference ?? '',
                            $row->sort_code ?? '',
                            $row->account_number ?? '',
                            $row->account_name ?? '',
                            $row->amount ?? 0,
                            $row->bacs_code ?? '',
                            '', // Invoice No (Optional)
                            '', // Title
                            $row->initial ?? '',
                            $row->forename ?? '',
                            $row->surname ?? '',
                            '', // Salutation 1
                            '', // Salutation 2
                            '', // Address 1
                            '', // Address 2
                            '', // Area
                            '', // Town
                            '', // Postcode
                            '', // Phone
                            '', // Mobile
                            '', // Email
                            $row->error_message ?? '',
                        ];
                    });
            }

            public function headings(): array
            {
                return [
                    'DD REFERENCE',
                    'Sort Code',
                    'Account No',
                    'Account Name',
                    'Amount',
                    'BACS Code',
                    'Invoice No (Optional)',
                    'Title',
                    'Initial',
                    'Forename',
                    'Surname',
                    'Salutation 1',
                    'Salutation 2',
                    'Address 1',
                    'Address 2',
                    'Area',
                    'Town',
                    'Postcode',
                    'Phone',
                    'Mobile',
                    'Email',
                    'Notes (Optional)',
                ];
            }
        }, 'fastpay-export-' . $file->file_name . '-' . now()->format('Ymd') . '.xlsx');
    }
}