<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@pos.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '08123456788',
            'address' => 'Jl. Manager No. 1',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'cashier@pos.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'phone' => '08123456787',
            'address' => 'Jl. Kasir No. 1',
            'is_active' => true,
        ]);
    }
}






