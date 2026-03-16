<?php

namespace App\Services;

use App\Gateways\GatewayManager;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected GatewayManager $gatewayManager;

    public function __construct(GatewayManager $gatewayManager){
        $this->gatewayManager = $gatewayManager;
    }

    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            $total = 0;
            $productsToAttach = [];

            foreach ($data['products'] as $pData) {
                $product = Product::findOrFail($pData['id']);
                $total += $product->amount * $pData['quantity']; 
                
                $productsToAttach[$product->id] = [
                    'quantity' => $pData['quantity'],
                    'amount' => $product->amount
                ];
            }

            $transaction = Transaction::create([
                'client_id' => $data['client_id'],
                'amount' => $total,
                'status' => 'pending',
                'card_last_numbers' => substr($data['card_number'], -4)
            ]);

            $transaction->products()->attach($productsToAttach);
            $data['amount'] = $total;

            try {
                $result = $this->gatewayManager->process($data);

                $transaction->update([
                    'status' => 'approved',
                    'external_id' => $result['response']['id'],
                    'gateway_id' => $result['gateway']->id
                ]);

            } catch (\Exception $e) {
                $transaction->update(['status' => 'failed']);
                throw $e;
            }

            return $transaction;
        });
    }

    public function getTransaction(int $id)
    {
        return Transaction::with('products')->findOrFail($id);
    }

    public function listTransactions()
    {
        return Transaction::with('products')->paginate();
    }

    public function refundTransaction(int $id)
    {
        $transaction = Transaction::with('gateway')->findOrFail($id);

        if (!$transaction->gateway || !$transaction->external_id) {
            throw new \Exception("gateway data not found for this transaction.");
        }

        try {
            $result = $this->gatewayManager->refund($transaction->gateway->name, $transaction->external_id);

            if (isset($result['id'])) {
                $transaction->update(['status' => 'refunded']);
            } else {
                throw new \Exception('Refund failed: ' . $result['message']);
            }
        } catch (\Exception $e) {
            logger()->error('Refund failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }

        return $transaction;
    }
}