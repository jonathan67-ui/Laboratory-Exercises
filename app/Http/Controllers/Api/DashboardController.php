<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Services\ReorderService;

class DashboardController extends Controller
{
    public function pendingOrders()
    {
        return response()->json([
            'count' => PurchaseOrder::where('status', 'pending')->count()
        ]);
    }

    public function recentOrders()
    {
        return response()->json(
            PurchaseOrder::with('supplier')
                ->latest()
                ->take(5)
                ->get()
        );
    }

    public function supplierPerformance()
    {
        return response()->json(
            Supplier::withCount('purchaseOrders')
                ->latest()
                ->take(5)
                ->get()
        );
    }

    public function reorderAlerts(ReorderService $service)
    {
        return response()->json(
            $service->getProductsNeedingReorder()
        );
    }
}
