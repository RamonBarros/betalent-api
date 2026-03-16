<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Gateway::create([
            'name' => 'gateway_one',
            'is_active' => true,
            'priority' => 1
        ]);

        \App\Models\Gateway::create([
            'name' => 'gateway_two',
            'is_active' => true,
            'priority' => 2
        ]);
    }
}
