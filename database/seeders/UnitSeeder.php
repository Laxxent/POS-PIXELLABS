<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Pieces', 'symbol' => 'pcs', 'description' => 'Satuan per buah'],
            ['name' => 'Kilogram', 'symbol' => 'kg', 'description' => 'Satuan per kilogram'],
            ['name' => 'Gram', 'symbol' => 'gr', 'description' => 'Satuan per gram'],
            ['name' => 'Liter', 'symbol' => 'L', 'description' => 'Satuan per liter'],
            ['name' => 'Meter', 'symbol' => 'm', 'description' => 'Satuan per meter'],
            ['name' => 'Centimeter', 'symbol' => 'cm', 'description' => 'Satuan per centimeter'],
            ['name' => 'Box', 'symbol' => 'box', 'description' => 'Satuan per box'],
            ['name' => 'Pack', 'symbol' => 'pack', 'description' => 'Satuan per pack'],
            ['name' => 'Dus', 'symbol' => 'dus', 'description' => 'Satuan per dus'],
            ['name' => 'Botol', 'symbol' => 'botol', 'description' => 'Satuan per botol'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}






