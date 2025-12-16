<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankValidationController extends Controller
{
  

public function validateBank(Request $request)
{
    $sortCode = $request->query('sortCode');

    Log::info('Bank lookup requested', [
        'sortCode' => $sortCode
    ]);

    if (!$sortCode) {
        Log::warning('Sort code missing');
        return response()->json([
            'error' => true,
            'message' => 'Sort code is required.'
        ]);
    }

    $apiKey = 'YN39-KY58-YB56-HB99';

    $apiUrl = 'https://api.addressy.com/BankAccountValidation/Interactive/RetrieveBySortcode/v1.00/json6.ws';

    Log::info('Calling Loqate RetrieveBySortcode API', [
        'url' => $apiUrl,
        'sortCode' => $sortCode
    ]);

    try {
        $response = Http::get($apiUrl, [
            'Key' => $apiKey,
            'SortCode' => $sortCode,
        ]);

        Log::info('HTTP status', ['status' => $response->status()]);
        Log::info('Raw response', ['body' => $response->body()]);

        $data = $response->json();

        Log::info('Parsed JSON', ['data' => $data]);

        if (!isset($data['Items'][0])) {
            Log::warning('No bank data returned', ['response' => $data]);
            return response()->json([
                'error' => true,
                'message' => 'Invalid sort code or bank not found.'
            ]);
        }

        $item = $data['Items'][0];

        return response()->json([
            'error' => false,
            'bankName'   => $item['Bank'] ?? '',
            'branchName' => $item['Branch'] ?? '',
            'bic'        => $item['BankBIC'] ?? '',
            'fps'        => $item['FasterPaymentsSupported'] ?? false,
            'chaps'      => $item['CHAPSSupported'] ?? false,
        ]);

    } catch (\Exception $e) {
        Log::error('Bank lookup exception', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'error' => true,
            'message' => 'Server error. Please try again later.'
        ], 500);
    }
}

}


