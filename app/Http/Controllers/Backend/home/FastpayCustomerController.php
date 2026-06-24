<?php

namespace App\Http\Controllers\Backend\home;

use App\Http\Controllers\Controller;
use App\Services\FastPayService;
use Illuminate\Support\Facades\Log;

class FastpayCustomerController extends Controller
{
    protected FastPayService $fastpay;

    public function __construct(FastPayService $fastpay)
    {
        $this->fastpay = $fastpay;
    }

    /**
     * Customers tab — list every FastPay customer with their status.
     */
    public function index()
    {
        $customers = [];
        $error     = null;

        try {
            $customers = $this->fastpay->getAllCustomers();
        } catch (\Throwable $e) {
            $error = 'Could not load customers from FastPay: ' . $e->getMessage();
            Log::error('FastPay customers list failed', ['error' => $e->getMessage()]);
        }

        return view('backend.fastpay-customers.index', compact('customers', 'error'));
    }

    /**
     * Customer detail (the "+" expand / modal) — profile + transactions.
     * Returns JSON consumed by the modal via fetch().
     */
    public function show(string $ddReference)
    {
        try {
            $data = $this->fastpay->getCustomerDetail($ddReference);

            return response()->json([
                'success'      => true,
                'customer'     => $data['Customer'] ?? null,
                'transactions' => $this->normaliseTransactions($data['Transactions'] ?? []),
            ]);
        } catch (\Throwable $e) {
            Log::error('FastPay customer detail failed', ['ref' => $ddReference, 'error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reduce FastPay's verbose transaction objects to what the UI needs and
     * derive a human label for the status.
     *
     * NOTE: FastPay returns SubmissionStatus / WebStatus as numeric codes and
     * does not document them. We derive Paid/Failed from ErrorCodeID (0 = no
     * error) and surface any ErrorCode/WebStatusDetails text when present.
     * Adjust statusLabel() once the official code list is confirmed.
     */
    private function normaliseTransactions(array $transactions): array
    {
        return array_map(function ($t) {
            return [
                'submission_date' => $this->formatDate($t['SubmissionDate'] ?? null),
                'amount'          => (float) ($t['Amount'] ?? 0),
                'bacs_code'       => $t['BacsCode'] ?? '',
                'account_name'    => $t['CustomerAccountName'] ?? '',
                'sort_code'       => $t['SortCode'] ?? '',
                'account_number'  => $t['AccountNumber'] ?? '',
                'file_name'       => $t['ImportFileName'] ?? '',
                'status'          => $this->statusLabel($t),
            ];
        }, $transactions);
    }

    private function statusLabel(array $t): string
    {
        if (!empty($t['WebStatusDetails'])) return (string) $t['WebStatusDetails'];
        if (!empty($t['ErrorCode']))        return (string) $t['ErrorCode'];

        return (int) ($t['ErrorCodeID'] ?? 0) === 0 ? 'Paid' : 'Failed';
    }

    private function formatDate(?string $raw): string
    {
        if (!$raw || str_starts_with($raw, '0001-01-01')) return '';

        try {
            return \Carbon\Carbon::parse($raw)->format('d/m/Y');
        } catch (\Throwable $e) {
            return '';
        }
    }
}
