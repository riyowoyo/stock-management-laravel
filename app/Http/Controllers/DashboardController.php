<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        // total barang masuk & keluar
        $totalIn = Transaction::where('type', 'in')->sum('quantity');
        $totalOut = Transaction::where('type', 'out')->sum('quantity');

        // ambil daftar transaksi masuk & keluar
        $transactionsIn = Transaction::with('product')
            ->where('type', 'in')
            ->latest()
            ->get();

        $transactionsOut = Transaction::with('product')
            ->where('type', 'out')
            ->latest()
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalIn',
            'totalOut',
            'transactionsIn',
            'transactionsOut'
        ));
    }
}
