@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Dashboard</h2>

    {{-- Summary Cards --}}
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-bg-primary shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h6 class="card-title">Jenis Barang</h6>
                    <p class="display-5 fw-bold mb-0">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>  

    {{-- Tabel Barang Masuk & Keluar --}}
    <div class="row mt-4 g-3">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white fw-bold">
                    📥 Barang Masuk
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light">
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
                                        <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white fw-bold">
                    📤 Barang Keluar
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light">
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
                                        <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
