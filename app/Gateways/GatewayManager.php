<?php
namespace App\Gateways;

use App\Models\Gateway;

class GatewayManager
{
    protected $adapters;

    public function __construct(iterable $gateways) {
        foreach ($gateways as $gateway) {
            $this->adapters[$gateway->getName()] = $gateway;
        }
    }

    public function process(array $data)
    {
        $gateways = Gateway::where('is_active', true)->orderBy('priority')->get();

        foreach ($gateways as $gateway) {

            $adapter = $this->adapters[$gateway->name] ?? null;

            if (!$adapter) {
                continue;
            }

            try {

                $response = $adapter->processPayment($data);

                return [
                    'gateway' => $gateway,
                    'response' => $response
                ];

                

            } catch (\Exception $e) {

                logger()->error('Gateway failed', [
                    'gateway' => $gateway->name,
                    'error' => $e->getMessage()
                ]);

            }
        }

        throw new \Exception('All gateways failed');
    }

    public function refund($gateway_name, $external_id)
    {

        $adapter = $this->adapters[$gateway_name] ?? null;

        if (!$adapter) {
            throw new \Exception("Adapter for {$gateway_name} not found.");
        }

        return $adapter->refund($external_id);
    }
}