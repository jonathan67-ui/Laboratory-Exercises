<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

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