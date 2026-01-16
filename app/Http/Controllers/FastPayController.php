<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FastPayController extends Controller
{
    public function form()
    {
        Log::info('FastPay: Upload form opened');
        return view('fastpay.upload');
    }

    public function upload(Request $request)
    {
        Log::info('FastPay: Upload started');

        // 1️⃣ Validate
        $request->validate([
            'file' => 'required|mimes:csv'
        ]);
        Log::info('FastPay: File validation passed');

        // 2️⃣ Read file
        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        Log::info('FastPay: File received', [
            'name' => $fileName,
            'path' => $filePath,
            'size' => $file->getSize()
        ]);

        $fileData = file_get_contents($filePath);

        if ($fileData === false) {
            Log::error('FastPay: File read failed');
            return back()->with('error', 'File read error');
        }

        Log::info('FastPay: File read successful');

        // 3️⃣ FastPay DATE FORMAT (CRITICAL)
        $submissionDate = strtoupper(date('d/M/Y'));
        $uploadDate     = strtoupper(date('d/M/Y'));

        Log::info('FastPay: Dates prepared', [
            'submission_date' => $submissionDate,
            'upload_date' => $uploadDate
        ]);

        // 4️⃣ Payload (EXACT FastPay spec)
        $payload = [
            "MessageControl" => [
                "Version" => "1.0"
            ],
            "Data" => [
                "Filename"       => $fileName,
                "FileContent"    => base64_encode($fileData),
                "SubmissionDate" => $submissionDate,
                "UploadDate"     => $uploadDate
            ]
        ];

        Log::info('FastPay: Payload ready', ['payload' => $payload]);

        // 5️⃣ API Call (RAW cURL – REQUIRED)
        $url = env('FASTPAY_BASE_URL') . 'api/Files';

        Log::info('FastPay: API URL', ['url' => $url]);
        Log::info('FastPay: Token length', ['length' => strlen(env('FASTPAY_TOKEN'))]);

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Bearer-Token: ' . env('FASTPAY_TOKEN'),
        ];

        Log::info('FastPay: Request headers', $headers);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $responseBody = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($responseBody === false) {
            $curlError = curl_error($ch);
            curl_close($ch);

            Log::error('FastPay: cURL error', ['error' => $curlError]);
            return back()->with('error', 'FastPay cURL Error: ' . $curlError);
        }

        curl_close($ch);

        Log::info('FastPay: API response received', [
            'status' => $responseCode,
            'body' => $responseBody
        ]);

        // 6️⃣ Response Handling
        if ($responseCode === 200) {
            Log::info('FastPay: Upload SUCCESS');
            return back()->with('success', 'File uploaded successfully to FastPay');
        }

        Log::error('FastPay: Upload FAILED', [
            'status' => $responseCode,
            'response' => $responseBody
        ]);

        return back()->with(
            'error',
            'FastPay Error: ' . $responseCode . ' - ' . $responseBody
        );
    }
}
