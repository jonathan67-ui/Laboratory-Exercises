<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'quantity',
        'reorder_level',
        'unit_price',
        'supplier',
    ];
    public function transactions()
{
    return $this->hasMany(InventoryTransaction::class);
}
public function isLowStock(): bool
{
    return $this->quantity <= $this->reorder_level;
}

public function isOutOfStock(): bool
{
    return $this->quantity <= 0;
}

public function getStockStatusAttribute(): string
{
    if ($this->isOutOfStock()) {
        return 'Out of Stock';
    }

    if ($this->isLowStock()) {
        return 'Low Stock';
    }

    return 'In Stock';
}

public function scopeLowStock($query)
{
    return $query->whereColumn(
        'quantity',
        '<=',
        'reorder_level'
    );
}
}