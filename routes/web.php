<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Root → redirect ke dashboard
Route::get('/', function () {
    return to_route('dashboard.index');
});

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route berikut membutuhkan user login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Activities / Audit
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

    // Products
    Route::resource('/products', ProductController::class);

    // Stock Card per produk
    Route::prefix('products/{product}')->group(function () {
        Route::get('/stock-card', [TransactionController::class, 'stockCard'])->name('products.stock-card');
        Route::get('/stock-card/pdf', [ProductController::class, 'exportStockCardPdf'])->name('products.stock-card.pdf');
        Route::get('/stock-card/excel', [ProductController::class, 'exportStockCardExcel'])->name('products.stock-card.excel');
    });

    // Transactions
    Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.pdf');
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
});
Route::resource('/transactions', TransactionController::class);
