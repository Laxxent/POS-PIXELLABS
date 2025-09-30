<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'barcode',
        'sku',
        'description',
        'category_id',
        'unit_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'wholesale_price',
        'price',
        'stock',
        'min_stock',
        'image',
        'has_serial_number',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'price' => 'decimal:2',
        'has_serial_number' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit that owns the product
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the supplier that owns the product
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get sale items for this product
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get purchase items for this product
     */
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get stock movements for this product
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for low stock products
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock <= min_stock');
    }

    /**
     * Check if product is low stock
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }


    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        // Use price column if it has value, otherwise use selling_price
        $price = (!empty($this->price) && $this->price > 0) ? $this->price : $this->selling_price;
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Get formatted wholesale price
     */
    public function getFormattedWholesalePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->wholesale_price, 0, ',', '.');
    }
}






