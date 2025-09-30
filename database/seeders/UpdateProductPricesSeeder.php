<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateProductPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \DB::table('products')->get();
        
        foreach ($products as $product) {
            // Update price column with selling_price value if price is null or 0
            if (empty($product->price) || $product->price == 0) {
                \DB::table('products')
                    ->where('id', $product->id)
                    ->update(['price' => $product->selling_price]);
            }
        }
        
        echo "Product prices updated successfully!\n";
    }
}
