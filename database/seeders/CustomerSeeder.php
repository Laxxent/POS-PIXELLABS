<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Toko Sumber Jaya',
                'email' => 'info@sumberjaya.com',
                'phone' => '021-99887766',
                'address' => 'Jl. Sumber Jaya No. 10, Jakarta',
                'type' => 'wholesale',
                'credit_limit' => 10000000,
                'current_balance' => 0,
            ],
            [
                'name' => 'CV. Mitra Sejahtera',
                'email' => 'mitra@sejahtera.com',
                'phone' => '021-55443322',
                'address' => 'Jl. Mitra Sejahtera No. 5, Bandung',
                'type' => 'wholesale',
                'credit_limit' => 15000000,
                'current_balance' => 0,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}






