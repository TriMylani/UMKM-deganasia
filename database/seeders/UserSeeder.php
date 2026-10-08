<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Deganasia',
            'email' => 'admin@deganasia.test',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer Deganasia',
            'email' => 'customer@deganasia.test',
            'password' => Hash::make('customer12345'),
            'role' => 'customer',
        ]);
    }
}