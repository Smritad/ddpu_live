<?php
namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; // 👈 Add this at the top

use App\Models\File;
use App\Models\FileDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FileDataImport;
use App\Exports\FileDataExport;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FilesDetailsController extends Controller
{
    public function index()
    {
        $files = File::latest()->get();
        return view('backend.files.index', compact('files'));
    }



public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv,ods,xml,txt',
        'collection_date' => 'nullable|date'
    ]);

    $uploadedFile   = $request->file('file');
    $fileName       = $uploadedFile->getClientOriginalName();
    $collectionDate = $request->collection_date;
    $uploadedDate   = now();

    /* -------------------------------------------------
     | 1️⃣ CREATE FILE RECORD FIRST
     ------------------------------------------------- */
    $file = File::create([
        'file_name'       => $fileName,
        'collection_date' => $collectionDate,
        'uploaded_date'   => $uploadedDate,
        'notes'           => $request->notes ?? null,
    ]);

    try {
        Log::info('📁 Import started', [
            'file_name' => $fileName,
            'file_id' => $file->id,
            'collection_date' => $collectionDate,
        ]);

        /* -------------------------------------------------
         | 2️⃣ SEND FILE TO FASTPAY
         ------------------------------------------------- */
        $rawFile   = file_get_contents($uploadedFile->getRealPath());
        $base64    = base64_encode($rawFile);

        $fastpayPayload = [
            "MessageControl" => [
                "Version" => "1"
            ],
            "Data" => [
                "Filename"       => $fileName,
                "FileContent"    => $base64,
                "SubmissionDate" => $collectionDate
                    ? Carbon::parse($collectionDate)->format('Y-m-d')
                    : now()->format('Y-m-d'),
                "UploadDate"     => now()->format('Y-m-d'),
            ]
        ];

        $fastpayResponse = Http::withHeaders([
            'Accept'       => 'application/json',
            'Bearer-Token' => config('services.fastpay.token'),
        ])->post(
            config('services.fastpay.url') . '/api/Files',
            $fastpayPayload
        );

        if (!$fastpayResponse->successful()) {
            throw new \Exception(
                'FastPay API error: ' . $fastpayResponse->body()
            );
        }

        Log::info('🚀 FastPay upload successful', [
            'file_id' => $file->id,
        ]);

        /* -------------------------------------------------
         | 3️⃣ STORE FILE LOCALLY
         ------------------------------------------------- */
        $storedPath = $uploadedFile->store('uploads/fastpay');

        $file->update([
            'file_path'        => $storedPath,
            'fastpay_response' => $fastpayResponse->body(),
        ]);

        /* -------------------------------------------------
         | 4️⃣ EXCEL IMPORT (YOUR EXISTING LOGIC)
         ------------------------------------------------- */
        $data = Excel::toArray(new FileDataImport($file->id), $uploadedFile);

        Log::info('📄 Raw Excel Data', [
            'sheet_1_rows' => isset($data[0]) ? count($data[0]) : 0,
            'first_row' => $data[0][0] ?? [],
        ]);

        Excel::import(new FileDataImport($file->id), $uploadedFile);

        /* -------------------------------------------------
         | 5️⃣ COMPUTE TOTALS
         ------------------------------------------------- */
        $total    = FileDetail::where('file_id', $file->id)->sum('amount');
        $rowCount = FileDetail::where('file_id', $file->id)->count();

        $file->update([
            'total_amount' => $total
        ]);

        Log::info('✅ Import completed successfully', [
            'file_id' => $file->id,
            'rows_inserted' => $rowCount,
            'total_amount' => $total,
        ]);

        return redirect()->back()
            ->with('success', '✅ File uploaded to FastPay and imported successfully!');

    } catch (\Exception $e) {

        /* -------------------------------------------------
         | ❌ FULL ROLLBACK
         ------------------------------------------------- */
        if (!empty($file->file_path)) {
            Storage::delete($file->file_path);
        }

        $file->delete();

        Log::error('❌ Import failed', [
            'file_name' => $fileName,
            'error' => $e->getMessage(),
        ]);

        return redirect()->back()
            ->with('error', '❌ Import failed: ' . $e->getMessage());
    }
}







public function export($id)
{
    $file = File::findOrFail($id);

    // Format upload date for filename
    $datePart = $file->uploaded_date
        ? \Carbon\Carbon::parse($file->uploaded_date)->format('Ymd')
        : now()->format('Ymd');

    // Final filename like DDPULtd_20251024.csv
    $exportFileName = "DDPULtd_{$datePart}.csv";

    Log::info("🚀 Starting Direct Export for File ID: {$id} → {$exportFileName}");

    $details = FileDetail::where('file_id', $file->id)->get([
        'dd_reference','sort_code','account_no','account_name','amount',
        'bacs_code','invoice_no','title','initial','forename','surname',
        'salutation_1','salutation_2','address_1','address_2','area','town',
        'postcode','phone','mobile','email','notes'
    ]);

    $headings = [
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

    $response = new StreamedResponse(function () use ($headings, $details) {
        $handle = fopen('php://output', 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
        fputcsv($handle, $headings);

        foreach ($details as $row) {
            fputcsv($handle, [
                $row->dd_reference,
                $row->sort_code,
                $row->account_no,
                $row->account_name,
                number_format((float) $row->amount, 2, '.', ''),
                $row->bacs_code,
                $row->invoice_no,
                $row->title,
                $row->initial,
                $row->forename,
                $row->surname,
                $row->salutation_1,
                $row->salutation_2,
                $row->address_1,
                $row->address_2,
                $row->area,
                $row->town,
                $row->postcode,
                $row->phone,
                $row->mobile,
                $row->email,
                $row->notes,
            ]);
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $exportFileName . '"');

    Log::info("✅ Export complete for File ID: {$id} ({$details->count()} rows)");

    return $response;
}


}
