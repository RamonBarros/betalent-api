<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        RoleSeeder::class,
        GatewaySeeder::class,
    ]);
    \App\Models\Product::factory(10)->create();
    \App\Models\Client::factory(5)->create();

    $rolesMap = [
        'ADMIN'   => 1,
        'MANAGER' => 2,
        'FINANCE' => 3,
        'USER'    => 4,
    ];

    foreach ($rolesMap as $roleName => $roleId) {
        \App\Models\User::updateOrCreate(
            ['email' => strtolower($roleName) . '@admin.com'],
            [
                'name'     => "User " . $roleName,
                'password' => bcrypt('password'),
                'role_id'  => $roleId, 
            ]
        );
    }
}
}
