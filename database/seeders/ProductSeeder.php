<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        $products = [
            [
                'name' => 'Nasi Goreng Spesial',
                'code' => 'NG001',
                'barcode' => '1234567890123',
                'sku' => 'NG001',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran',
                'category_id' => $categories->where('name', 'Makanan & Minuman')->first()->id,
                'unit_id' => $units->where('symbol', 'pcs')->first()->id,
                'supplier_id' => $suppliers->first()->id,
                'purchase_price' => 15000,
                'selling_price' => 25000,
                'wholesale_price' => 20000,
                'stock' => 50,
                'min_stock' => 10,
            ],
            [
                'name' => 'Smartphone Samsung Galaxy',
                'code' => 'SP001',
                'barcode' => '2345678901234',
                'sku' => 'SP001',
                'description' => 'Smartphone Android dengan kamera 64MP',
                'category_id' => $categories->where('name', 'Elektronik')->first()->id,
                'unit_id' => $units->where('symbol', 'pcs')->first()->id,
                'supplier_id' => $suppliers->first()->id,
                'purchase_price' => 2500000,
                'selling_price' => 3500000,
                'wholesale_price' => 3000000,
                'stock' => 10,
                'min_stock' => 2,
                'has_serial_number' => true,
            ],
            [
                'name' => 'Kaos Polo Cotton',
                'code' => 'KP001',
                'barcode' => '3456789012345',
                'sku' => 'KP001',
                'description' => 'Kaos polo dengan bahan cotton premium',
                'category_id' => $categories->where('name', 'Pakaian')->first()->id,
                'unit_id' => $units->where('symbol', 'pcs')->first()->id,
                'supplier_id' => $suppliers->skip(1)->first()->id,
                'purchase_price' => 75000,
                'selling_price' => 125000,
                'wholesale_price' => 100000,
                'stock' => 100,
                'min_stock' => 20,
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'code' => 'VC001',
                'barcode' => '4567890123456',
                'sku' => 'VC001',
                'description' => 'Vitamin C dengan dosis 1000mg per tablet',
                'category_id' => $categories->where('name', 'Kesehatan')->first()->id,
                'unit_id' => $units->where('symbol', 'botol')->first()->id,
                'supplier_id' => $suppliers->skip(2)->first()->id,
                'purchase_price' => 45000,
                'selling_price' => 75000,
                'wholesale_price' => 60000,
                'stock' => 30,
                'min_stock' => 5,
            ],
            [
                'name' => 'Panci Stainless Steel',
                'code' => 'PS001',
                'barcode' => '5678901234567',
                'sku' => 'PS001',
                'description' => 'Panci stainless steel dengan tutup kaca',
                'category_id' => $categories->where('name', 'Rumah Tangga')->first()->id,
                'unit_id' => $units->where('symbol', 'pcs')->first()->id,
                'supplier_id' => $suppliers->first()->id,
                'purchase_price' => 120000,
                'selling_price' => 200000,
                'wholesale_price' => 160000,
                'stock' => 25,
                'min_stock' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}






