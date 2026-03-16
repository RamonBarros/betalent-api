<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $roles = ['ADMIN', 'MANAGER', 'FINANCE', 'USER'];

        foreach ($roles as $role) {
            \App\Models\Role::create(['name' => $role]);
        }
    }
}
