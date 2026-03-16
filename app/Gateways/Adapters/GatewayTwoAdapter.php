<?php

namespace App\Gateways\Adapters;

use Illuminate\Support\Facades\Http;
use App\Gateways\Contracts\PaymentGatewayInterface;

class GatewayTwoAdapter implements PaymentGatewayInterface
{
    // protected $baseUrl = 'http://localhost:3002';
    protected $baseUrl = 'http://gateways-mock:3002';

    protected function headers()
    {
        return [
            'Gateway-Auth-Token' => 'tk_f2198cc671b5289fa856',
            'Gateway-Auth-Secret' => '3d15e8ed6131446ea7e3456728b1211f'
        ];
    }

    public function getName(): string
    {
        return 'gateway_two';
    }
    
    public function processPayment(array $data): array {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/transacoes', [
                'valor' => $data['amount'],
                'nome' => $data['name'],
                'email' => $data['email'],
                'numeroCartao' => $data['card_number'],
                'cvv' => $data['cvv']
            ])->json();
    }

    public function listTransactions()
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl.'/transacoes')
            ->json();
    }

    public function refund(string $transactionId)
    {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl.'/transacoes/reembolso', [
                'id' => $transactionId
            ])
            ->json();
    }
}