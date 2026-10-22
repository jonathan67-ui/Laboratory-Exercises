<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get(
    '/dashboard/stats',
    [DashboardController::class, 'stats']
);