<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FastPayService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.fastpay.base_url');
        $this->token   = config('services.fastpay.token');
    }

    private function headers()
    {
        return [
            'Accept' => 'application/json',
            'Bearer-Token' => $this->token,
        ];
    }

    public function uploadFile(array $payload)
    {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl . 'api/Files', $payload);
    }

    public function getCustomer(array $params)
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl . 'api/Customers/GetCustomer', $params);
    }

    public function getCustomerBounces(array $params)
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl . 'api/Customers/GetCustomerBounces', $params);
    }

    public function getCustomersByStatus(string $status)
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl . 'api/Customers/GetCustomers', [
                'Status' => $status
            ]);
    }
}
