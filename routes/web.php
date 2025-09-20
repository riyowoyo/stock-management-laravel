<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.pdf');

Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');

Route::resource('/products', ProductController::class);

Route::resource('/dashboard', DashboardController::class);

Route::resource('/transactions', TransactionController::class);

