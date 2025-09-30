<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreSetting::create([
            'store_name' => 'POS Store',
            'store_address' => 'Jl. Raya POS No. 1, Jakarta 12345',
            'store_phone' => '021-12345678',
            'store_email' => 'info@posstore.com',
            'store_logo' => null,
            'currency' => 'IDR',
            'tax_rate' => 10.00,
            'enable_tax' => true,
            'enable_barcode' => true,
            'enable_serial_number' => true,
        ]);
    }
}






