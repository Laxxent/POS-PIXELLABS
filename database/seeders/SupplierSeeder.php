<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Supplier Utama',
                'email' => 'info@supplierutama.com',
                'phone' => '021-12345678',
                'address' => 'Jl. Supplier Utama No. 1, Jakarta',
                'contact_person' => 'Budi Santoso',
                'credit_limit' => 50000000,
                'current_balance' => 0,
            ],
            [
                'name' => 'CV. Distributor Jaya',
                'email' => 'sales@distributorjaya.com',
                'phone' => '021-87654321',
                'address' => 'Jl. Distributor Jaya No. 2, Bandung',
                'contact_person' => 'Siti Aminah',
                'credit_limit' => 30000000,
                'current_balance' => 0,
            ],
            [
                'name' => 'UD. Grosir Makmur',
                'email' => 'grosir@makmur.com',
                'phone' => '021-11223344',
                'address' => 'Jl. Grosir Makmur No. 3, Surabaya',
                'contact_person' => 'Ahmad Wijaya',
                'credit_limit' => 25000000,
                'current_balance' => 0,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}






