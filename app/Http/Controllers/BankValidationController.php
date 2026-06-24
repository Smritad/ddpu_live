<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankValidationController extends Controller
{
    public function validateBank(Request $request)
    {
        $sortCode      = $request->query('sortCode');
        $accountNumber = $request->query('accountNumber');
        $accountHolder = $request->query('accountHolder');

        Log::info('Bank validation requested', [
            'sortCode'      => $sortCode,
            'accountNumber' => $accountNumber,
            'accountHolder' => $accountHolder,
        ]);

        if (!$sortCode) {
            return response()->json([
                'error'   => true,
                'message' => 'Sort code is required.',
            ]);
        }

        $apiKey = 'YN39-KY58-YB56-HB99';

        try {
            /* ══════════════════════════════════════════════
             |  STEP 1 — Validate sort code exists
             ══════════════════════════════════════════════ */
            $sortResponse = Http::get(
                'https://api.addressy.com/BankAccountValidation/Interactive/RetrieveBySortcode/v1.00/json6.ws',
                [
                    'Key'      => $apiKey,
                    'SortCode' => $sortCode,
                ]
            );

            Log::info('Loqate RetrieveBySortcode response', [
                'status' => $sortResponse->status(),
                'body'   => $sortResponse->body(),
            ]);

            $sortData = $sortResponse->json();

            if (!isset($sortData['Items'][0]) || empty($sortData['Items'][0]['Bank'])) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Invalid sort code or bank not found.',
                ]);
            }

            $sortItem = $sortData['Items'][0];

            /* If only sort code lookup (no account number passed) return bank info only */
            if (!$accountNumber) {
                return response()->json([
                    'error'      => false,
                    'bankName'   => $sortItem['Bank']    ?? '',
                    'branchName' => $sortItem['Branch']  ?? '',
                    'bic'        => $sortItem['BankBIC'] ?? '',
                ]);
            }

            /* ══════════════════════════════════════════════
             |  STEP 2 — Validate sort code + account number
             ══════════════════════════════════════════════ */
            $valResponse = Http::get(
                'https://api.addressy.com/BankAccountValidation/Interactive/Validate/v2.00/json6.ws',
                [
                    'Key'           => $apiKey,
                    'SortCode'      => $sortCode,
                    'AccountNumber' => $accountNumber,
                ]
            );

            Log::info('Loqate Validate response', [
                'status' => $valResponse->status(),
                'body'   => $valResponse->body(),
            ]);

            $valData = $valResponse->json();
            $valItem = $valData['Items'][0] ?? null;

            if (!$valItem) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Unable to validate account details. Please try again.',
                ]);
            }

            /* IsCorrect can come back as boolean or string */
            $isCorrect = filter_var($valItem['IsCorrect'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if (!$isCorrect) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Account number does not match this sort code. Please check your details.',
                ]);
            }

            /* ══════════════════════════════════════════════
             |  STEP 3 — Return full valid result
             ══════════════════════════════════════════════ */
            return response()->json([
                'error'          => false,
                'accountValid'   => true,
                'bankName'       => $valItem['Bank']                    ?? $sortItem['Bank']    ?? '',
                'branchName'     => $valItem['Branch']                  ?? $sortItem['Branch']  ?? '',
                'bic'            => $valItem['BankBIC']                 ?? $sortItem['BankBIC'] ?? '',
                'fasterPayments' => $valItem['FasterPaymentsSupported'] ?? false,
                'chaps'          => $valItem['CHAPSSupported']          ?? false,
            ]);

        } catch (\Exception $e) {
            Log::error('Bank validation exception', ['error' => $e->getMessage()]);

            return response()->json([
                'error'   => true,
                'message' => 'Server error. Please try again later.',
            ], 500);
        }
    }
}