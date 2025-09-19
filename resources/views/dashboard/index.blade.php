@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        {{-- Card Total Barang --}}
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text display-6">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        {{-- Card Barang Masuk --}}
        <div class="col-md-4">
            <div class="card text-bg-success mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📥 Barang Masuk</h5>
                    <p class="card-text display-6">{{ $totalIn }}</p>
                </div>
            </div>
        </div>

        {{-- Card Barang Keluar --}}
        <div class="col-md-4">
            <div class="card text-bg-danger mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📥 Barang Keluar</h5>
                    <p class="card-text display-6">{{ $totalOut }}</p>
                </div>
            </div>
        </div>
    </div>

{{-- Tabel Barang Masuk & Keluar --}}
<div class="row mt-4">
    {{-- Tabel Barang Masuk --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white">📥 Barang Masuk</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactionsIn as $t)
                            <tr>
                                <td>{{ $t->product->product_code }}</td>
                                <td>{{ $t->product->name }}</td>
                                <td>{{ $t->quantity }}</td>
                                <td>{{ $t->date }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabel Barang Keluar --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-danger text-white">📤 Barang Keluar</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactionsOut as $t)
                            <tr>
                                <td>{{ $t->product->product_code }}</td>
                                <td>{{ $t->product->name }}</td>
                                <td>{{ $t->quantity }}</td>
                                <td>{{ $t->date }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
