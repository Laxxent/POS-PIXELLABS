<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan & Minuman', 'description' => 'Berbagai jenis makanan dan minuman'],
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik dan gadget'],
            ['name' => 'Pakaian', 'description' => 'Pakaian pria, wanita, dan anak-anak'],
            ['name' => 'Kesehatan', 'description' => 'Produk kesehatan dan obat-obatan'],
            ['name' => 'Rumah Tangga', 'description' => 'Peralatan rumah tangga'],
            ['name' => 'Olahraga', 'description' => 'Peralatan olahraga dan fitness'],
            ['name' => 'Buku & Alat Tulis', 'description' => 'Buku, alat tulis, dan perlengkapan kantor'],
            ['name' => 'Mainan', 'description' => 'Mainan anak-anak'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}






