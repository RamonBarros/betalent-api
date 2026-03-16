<?php

namespace App\Gateways\Adapters;

use App\Gateways\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class GatewayOneAdapter implements PaymentGatewayInterface
{
    // protected $baseUrl = 'http://localhost:3001';
    protected $baseUrl = 'http://gateways-mock:3001';
    protected $token;

    public function getToken(){
        if($this->token){
            return $this->token;
        }

        $response = Http::post($this->baseUrl . '/login', [
            'email' => 'dev@betalent.tech',
            'token' => 'FEC9BB078BF338F464F96B48089EB498'
        ]);

        $this->token = $response['token'];

        return $this->token;
    }
    public function getName(): string
    {
        return 'gateway_one';
    }
    public function processPayment(array $data) :array {

        return Http::withToken($this->getToken())
                ->post($this->baseUrl . '/transactions', [
                    'amount' => (int) round($data['amount'] * 100), 
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'cardNumber' => $data['card_number'],
                    'cvv' => $data['cvv']
                ])->json();
    }

    public function listTransactions() {

        return Http::withToken($this->getToken())
            ->get($this->baseUrl.'/transactions')
            ->json();
    }

    public function refund(string $transactionId) {
        
        return Http::withToken($this->getToken())
            ->post($this->baseUrl."/transactions/{$transactionId}/charge_back")
            ->json();
    }
}