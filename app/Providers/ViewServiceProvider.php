<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Services\ReorderService;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('widgets.pending-orders', function ($view) {
            $view->with(
                'pendingOrders',
                PurchaseOrder::where('status', 'pending')->count()
            );
        });

        View::composer('widgets.recent-orders', function ($view) {
            $view->with(
                'recentOrders',
                PurchaseOrder::with('supplier')
                    ->latest()
                    ->take(5)
                    ->get()
            );
        });

        View::composer('widgets.supplier-performance', function ($view) {
            $view->with(
                'topSuppliers',
                Supplier::withCount('purchaseOrders')
                    ->latest()
                    ->take(5)
                    ->get()
            );
        });

        View::composer('widgets.reorder-alerts', function ($view) {
            $products = app(ReorderService::class)
                ->getProductsNeedingReorder();

            $view->with('reorderProducts', $products);
        });
    }
}
