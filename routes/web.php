<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;

// Main page: login for guests, inventory for logged-in users
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