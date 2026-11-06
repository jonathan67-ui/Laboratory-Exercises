<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
// Main page: login for guests, inventory for logged-in users
use App\Services\SearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\SupplierPerformanceController;
use App\Http\Controllers\ExportController;
Route::get(
    '/supplier-performance',
    [SupplierPerformanceController::class, 'index']
)->name('supplier-performance.index');
// Product CSV Export
Route::get('/exports/products', [ExportController::class, 'productsCsv'])
    ->name('exports.products');
 Route::get('/exports/products/pdf', [ExportController::class, 'productsPdf'])
    ->name('exports.products.pdf');
Route::middleware('auth')->group(function () {
    Route::get('/supplier-performance', [
        SupplierPerformanceController::class,
        'index'
    ])->name('suppliers.performance');
});
Route::middleware('auth')->group(function () {
    Route::get('/advanced-search', function (Request $request, SearchService $search) {
        $products = $search->products($request->all());
        $orders = $search->purchaseOrders($request->all());
        $transactions = $search->transactions($request->all());

        return view('search.index', compact(
            'products',
            'orders',
            'transactions'
        ));
    })->name('search.index');
});
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('inventory.index');
    }

    return redirect()->route('login');
});

// Login and registration: guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

// Product and inventory pages: logged-in users only
Route::middleware('auth')->group(function () {
    Route::resource('purchase-orders', PurchaseOrderController::class);

Route::post(
    'purchase-orders/{purchase_order}/approve',
    [PurchaseOrderController::class, 'approve']
)->name('purchase-orders.approve');

Route::post(
    'purchase-orders/{purchase_order}/reject',
    [PurchaseOrderController::class, 'reject']
)->name('purchase-orders.reject');

Route::post(
    'purchase-orders/{purchase_order}/send',
    [PurchaseOrderController::class, 'send']
)->name('purchase-orders.send');

Route::post(
    'purchase-orders/{purchase_order}/receive',
    [PurchaseOrderController::class, 'receive']
)->name('purchase-orders.receive');
    Route::resource('suppliers', SupplierController::class);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('products', ProductController::class)
        ->except(['show']);

    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

    Route::post('/inventory', [InventoryController::class, 'store'])
        ->name('inventory.store');

    Route::get('/inventory/summary', [InventoryController::class, 'summary'])
        ->name('inventory.summary');
        Route::delete('/notifications/{notification}', function (
    \Illuminate\Http\Request $request,
    string $notification
) {
    $item = $request->user()
        ->notifications()
        ->where('id', $notification)
        ->firstOrFail();

    $item->delete();

    return redirect()
        ->back()
        ->with('success', 'Notification dismissed.');
})->name('notifications.destroy');
Route::get('/notifications/latest', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'notifications' => $request->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at,
                ];
            }),
    ]);
})->name('notifications.latest');
});