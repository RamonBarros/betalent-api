<?php

namespace App\Services;

use App\Models\Gateway;

class GatewayService
{
    public function list()
    {
        return Gateway::orderBy('priority')->get();
    }

    public function toggleActive(int $gatewayId)
    {
        $gateway = Gateway::findOrFail($gatewayId);
        $gateway->update([
            'is_active' => !$gateway->is_active
        ]);

        return $gateway;
    }


    public function changePriority(int $gatewayId, int $priority)
    {
        $gateway = Gateway::findOrFail($gatewayId);

        $existing = Gateway::where('priority', $priority)->first();

        if ($existing && $existing->id !== $gatewayId) {

            $existing->update([
                'priority' => $gateway->priority
            ]);
        }

        $gateway->update([
            'priority' => $priority
        ]);

        return $gateway;
    }
}