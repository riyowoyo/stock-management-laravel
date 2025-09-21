@extends('layouts.app')

@section('title', 'Kartu Stok - ' . $product->name)

@section('content')
<div class="container-fluid px-4"> <!-- Biar fit di layout sidebar -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">📦 Kartu Stok: {{ $product->name }} ({{ $product->product_code }})</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('products.stock-card.pdf', $product->id) }}" class="btn btn-danger btn-sm">
                    📄 Export PDF
                </a>
                <a href="{{ route('products.stock-card.excel', $product->id) }}" class="btn btn-success btn-sm">
                    📊 Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Harga Satuan:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Masuk (Unit)</th>
                            <th>Keluar (Unit)</th>
                            <th>Harga Satuan (Rp)</th>
                            <th>Saldo Unit</th>
                            <th>Saldo (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $saldoUnit = 0;
                            $saldoRupiah = 0;
                        @endphp

                        @forelse ($transactions as $trx)
                            @php
                                $nominal = $trx->quantity * $product->price;

                                if ($trx->type === 'in') {
                                    $saldoUnit += $trx->quantity;
                                    $saldoRupiah += $nominal;
                                } else {
                                    $saldoUnit -= $trx->quantity;
                                    $saldoRupiah -= $nominal;
                                }
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                                <td>{{ $trx->description }}</td>
                                <td class="text-success text-center">{{ $trx->type === 'in' ? $trx->quantity : '' }}</td>
                                <td class="text-danger text-center">{{ $trx->type === 'out' ? $trx->quantity : '' }}</td>
                                <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="text-center"><strong>{{ $saldoUnit }}</strong></td>
                                <td class="text-end"><strong>Rp {{ number_format($saldoRupiah, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada transaksi untuk produk ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    ← Kembali ke Master Barang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
