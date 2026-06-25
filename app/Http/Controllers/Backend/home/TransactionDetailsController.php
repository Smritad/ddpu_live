<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use Carbon\Carbon;
use App\Models\FileDetail;
use App\Models\File;
use App\Exports\FileDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionDetailsController extends Controller
{
    public function index()
    {
        // Eager load related file name. Hide the 0N "setup only" lines (£0.00)
        // so the client sees only real collections — same as the FastPay portal.
        $fileDetails = FileDetail::with('file')
            ->whereRaw("UPPER(COALESCE(bacs_code,'')) <> '0N'")
            ->latest()
            ->get();
        return view('backend.transaction.index', compact('fileDetails'));
    }

    // CSV Export function
   public function exportCsv()
{
    $details = FileDetail::with('file')
        ->whereRaw("UPPER(COALESCE(bacs_code,'')) <> '0N'")
        ->get();
    $fileName = 'file_details_' . date('YmdHis') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ];

    $columns = [
        'DD Ref',
        'Account Name',
        'Collection Date',
        'BACS Code',
        'Amount',
        'Formatted File Name',
        'Status',
    ];

    $callback = function () use ($details, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($details as $detail) {
            $displayFileName = 'N/A';
            if (!empty($detail->file->file_name)) {
                $originalName = $detail->file->file_name;
                if (preg_match('/^([A-Za-z]+)[^0-9]*([0-9]{8})/', $originalName, $matches)) {
                    $name = strtoupper($matches[1]);
                    $date = \Carbon\Carbon::createFromFormat('Ymd', $matches[2])->format('y-m-d');
                    $displayFileName = "{$date} {$name} (Monthly on the 10th).xlsx";
                } else {
                    $displayFileName = $originalName;
                }
            }

            fputcsv($file, [
                $detail->dd_reference,
                $detail->account_name,
                $detail->file->collection_date ?? 'N/A',
                $detail->bacs_code,
                $detail->amount,
                $displayFileName,
                $detail->status ?? 'Pending',
            ]);
        }

        fclose($file);
    };

    return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, 200, $headers);
}

}