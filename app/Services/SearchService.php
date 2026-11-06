<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\InventoryTransaction;

class SearchService
{
    public function products(array $filters = [])
    {
        return Product::query()
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($filters['supplier_id'] ?? null, function ($query, $id) {
                $query->where('supplier_id', $id);
            })
            ->paginate(10)
            ->withQueryString();
    }

    public function purchaseOrders(array $filters = [])
    {
        return PurchaseOrder::with('supplier')
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('reference', 'like', "%{$search}%");
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['supplier_id'] ?? null, function ($query, $id) {
                $query->where('supplier_id', $id);
            })
            ->when($filters['from'] ?? null, function ($query, $date) {
                $query->whereDate('order_date', '>=', $date);
            })
            ->when($filters['to'] ?? null, function ($query, $date) {
                $query->whereDate('order_date', '<=', $date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function transactions(array $filters = [])
    {
        return InventoryTransaction::query()
            ->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($filters['user_id'] ?? null, function ($query, $id) {
                $query->where('user_id', $id);
            })
            ->when($filters['from'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($filters['to'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->paginate(10)
            ->withQueryString();
    }
}
