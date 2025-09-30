<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone',
        'store_email',
        'store_logo',
        'currency',
        'tax_rate',
        'enable_tax',
        'enable_barcode',
        'enable_serial_number',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'enable_tax' => 'boolean',
        'enable_barcode' => 'boolean',
        'enable_serial_number' => 'boolean',
    ];

    /**
     * Get the store settings (singleton)
     */
    public static function getSettings()
    {
        return static::first() ?? static::create([
            'store_name' => 'POS Store',
            'store_address' => 'Alamat Toko',
            'store_phone' => '08123456789',
            'store_email' => 'store@example.com',
            'currency' => 'IDR',
            'tax_rate' => 0,
            'enable_tax' => false,
            'enable_barcode' => true,
            'enable_serial_number' => false,
        ]);
    }
}






