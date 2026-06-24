<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FastPayService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        // NOTE: the config key is `services.fastpay.url` (see config/services.php).
        // Trailing slash is trimmed so endpoints can be appended cleanly.
        $this->baseUrl = rtrim((string) config('services.fastpay.url'), '/');
        $this->token   = config('services.fastpay.token');
    }

    private function headers()
    {
        return [
            'Accept'       => 'application/json',
            'Bearer-Token' => $this->token,
        ];
    }

    public function uploadFile(array $payload)
    {
        return Http::withOptions(['verify' => false])
            ->withHeaders($this->headers())
            ->post($this->baseUrl . '/api/Files', $payload);
    }

    public function getCustomer(array $params)
    {
        return Http::withOptions(['verify' => false])
            ->withHeaders($this->headers())
            ->get($this->baseUrl . '/api/Customers/GetCustomer', $params);
    }

    public function getCustomerBounces(array $params)
    {
        return Http::withOptions(['verify' => false])
            ->withHeaders($this->headers())
            ->get($this->baseUrl . '/api/Customers/GetCustomerBounces', $params);
    }

    public function getCustomersByStatus(string $status)
    {
        return Http::withOptions(['verify' => false])
            ->withHeaders($this->headers())
            ->get($this->baseUrl . '/api/Customers/GetCustomers', [
                'Status' => $status,
            ]);
    }

    /**
     * FastPay only returns customers one status at a time, so we query each
     * valid status and merge into a single list (mirrors the portal's
     * Customers tab which shows all customers with their status).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllCustomers(): array
    {
        $statuses = ['Live', 'Cancelled', 'Expired', 'Suspended'];
        $all = [];

        foreach ($statuses as $status) {
            $resp = $this->getCustomersByStatus($status);
            foreach (($resp->json('Data') ?? []) as $row) {
                $all[] = $row;
            }
        }

        return $all;
    }

    /**
     * Full detail for one customer: profile + transaction history.
     * Returns the FastPay "Data" payload ({ Customer: {...}, Transactions: [...] }).
     *
     * @return array<string, mixed>
     */
    public function getCustomerDetail(string $ddReference): array
    {
        $resp = $this->getCustomer(['DDReference' => $ddReference]);

        return $resp->json('Data') ?? ['Customer' => null, 'Transactions' => []];
    }
}
