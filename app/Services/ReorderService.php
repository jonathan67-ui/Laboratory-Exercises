<?php

namespace App\Services;

use App\Models\Product;

class ReorderService
{
    public function getLowStockProducts()
    {
        return Product::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->get();
    }

    public function getReorderCount()
    {
        return $this->getLowStockProducts()->count();
    }

    public function getReorderSuggestions()
    {
        return $this->getLowStockProducts()->map(function ($product) {
            return [
                'product' => $product->name,
                'current_stock' => $product->quantity,
                'reorder_level' => $product->reorder_level,
                'suggested_quantity' => max(
                    0,
                    ($product->reorder_level * 2) - $product->quantity
                ),
            ];
        });
    }
}
