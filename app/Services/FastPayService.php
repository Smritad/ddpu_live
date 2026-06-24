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
}
