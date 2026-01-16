<?php

namespace App\Http\Controllers\Backend\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FastPayFile;
use Illuminate\Support\Facades\Storage;
use App\Services\FastPayService;
use App\Models\FastPayLog;
class FastPayController extends Controller
{
    protected $fastPay;

    public function __construct(FastPayService $fastPay)
    {
        $this->fastPay = $fastPay;
    }

    public function upload(Request $request)
    {
        //dd($request);
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $fileData = file_get_contents($file->getRealPath());

        $payload = [
            "MessageControl" => [
                "Version" => "1"
            ],
            "Data" => [
                "Filename" => $file->getClientOriginalName(),
                "FileContent" => base64_encode($fileData),
                "SubmissionDate" => now()->subDays(2)->format('Y-m-d'),
                "UploadDate" => now()->format('Y-m-d')
            ]
        ];

        $response = $this->fastPay->uploadFile($payload);

        FastPayLog::create([
            'action' => 'FILE_UPLOAD',
            'filename' => $file->getClientOriginalName(),
            'request_payload' => json_encode($payload),
            'response_payload' => $response->body(),
            'status' => $response->successful() ? 'SUCCESS' : 'FAILED',
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'File uploaded to FastPay successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'FastPay API error',
            'error' => $response->body()
        ], 500);
    }
    



    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:csv,txt'
    //     ]);

    //     // Read CSV file
    //     $file = $request->file('file');
    //     $fileData = file_get_contents($file->getRealPath());

    //     if ($fileData === false) {
    //         return back()->with('error', 'File read error');
    //     }

    //     // Prepare payload
    //     $payload = [
    //         "MessageControl" => [
    //             "Version" => "1"
    //         ],
    //         "Data" => [
    //             "Filename" => $file->getClientOriginalName(),
    //             "FileContent" => base64_encode($fileData),
    //             "SubmissionDate" => now()->subDays(2)->format('Y-m-d'),
    //             "UploadDate" => now()->format('Y-m-d')
    //         ]
    //     ];

    //     // Call FastPay API
    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Bearer-Token' => config('services.fastpay.token'),
    //     ])->post(
    //         config('services.fastpay.base_url') . 'api/Files',
    //         $payload
    //     );

    //     if ($response->successful()) {
    //         return back()->with('success', 'File uploaded to FastPay successfully');
    //     }

    //     return back()->with('error', $response->body());
    // }
public function getCustomer(Request $request)
{
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Bearer-Token' => config('services.fastpay.token'),
    ])->get(
        config('services.fastpay.base_url') . 'api/Customers/GetCustomer',
        [
            'DDReference' => $request->dd_reference
        ]
    );

    return $response->json();
}

public function getCustomerBounces(Request $request)
{
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Bearer-Token' => config('services.fastpay.token'),
    ])->get(
        config('services.fastpay.base_url') . 'api/Customers/GetCustomerBounces',
        [
            'SortCode' => $request->sort_code,
            'AccountNumber' => $request->account_number,
            'Start' => $request->start_date,
            'End' => $request->end_date,
        ]
    );

    return $response->json();
}
public function getCustomersByStatus($status)
{
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Bearer-Token' => config('services.fastpay.token'),
    ])->get(
        config('services.fastpay.base_url') . 'api/Customers/GetCustomers',
        ['Status' => $status]
    );

    return $response->json();
}
public function remittance($year, $month, $day)
{
    $response = Http::withHeaders([
        'Bearer-Token' => config('services.fastpay.token'),
    ])->get(
        config('services.fastpay.base_url') . "api/files/$year/$month/$day"
    );

    return response($response->body(), 200)
        ->header('Content-Type', 'text/csv');
}




    
}

