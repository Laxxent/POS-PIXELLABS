<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateProductCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \DB::table('products')->whereNull('code')->get();
        
        foreach ($products as $product) {
            $code = 'PRD' . str_pad($product->id, 4, '0', STR_PAD_LEFT);
            \DB::table('products')->where('id', $product->id)->update(['code' => $code]);
        }
        
        echo "Product codes updated successfully!\n";
    }
}
