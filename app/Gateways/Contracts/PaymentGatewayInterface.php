<?php
namespace App\Gateways\Contracts;

interface PaymentGatewayInterface
{
    public function getName(): string;
    public function processPayment(array $data): array;
    public function listTransactions();
    public function refund(string $transactionId);

}