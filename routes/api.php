<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\SupplierPerformanceController;

Route::middleware('auth')->group(function () {
    Route::get('/supplier-performance', [
        SupplierPerformanceController::class,
        'index'
    ])->name('suppliers.performance');
});
Route::get('/inventory/transactions', [
    InventoryController::class,
    'apiTransactions',
]);

Route::get('/inventory/stats', [
    InventoryController::class,
    'dashboardStats',
]);

Route::get('/inventory/low-stock', [
    InventoryController::class,
    'lowStockProducts',
]);

Route::get('/inventory/recent', [
    InventoryController::class,
    'recentTransactions',
]);

Route::middleware('auth:sanctum')->prefix('dashboard')->group(function () {
    Route::get('/pending-orders', [DashboardController::class, 'pendingOrders']);
    Route::get('/recent-orders', [DashboardController::class, 'recentOrders']);
    Route::get('/supplier-performance', [DashboardController::class, 'supplierPerformance']);
    Route::get('/reorder-alerts', [DashboardController::class, 'reorderAlerts']);
});