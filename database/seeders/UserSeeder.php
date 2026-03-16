<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Master',
            'email' => 'admin@teste.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role_id' => 1,
        ]);
    }
}
