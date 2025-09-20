@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Transaksi</h3>

    {{-- Search --}}
    <div class="mb-3 d-flex">
        <form action="{{ route('transactions.index') }}" method="GET" class="d-flex w-100">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Kode/Nama/Deskripsi"
                value="{{ request('search') }}">
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>

    {{-- Filter & Tambah --}}
    <div class="d-flex mb-3">
        <a href="{{ route('transactions.index') }}"
           class="btn btn-outline-dark me-2 {{ request('type') ? '' : 'active' }}">
           Semua
        </a>
        <a href="{{ route('transactions.index', ['type' => 'in']) }}"
           class="btn btn-outline-success me-2 {{ request('type') == 'in' ? 'active' : '' }}">
           Barang Masuk
        </a>
        <a href="{{ route('transactions.index', ['type' => 'out']) }}"
           class="btn btn-outline-danger {{ request('type') == 'out' ? 'active' : '' }}">
           Barang Keluar
        </a>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary ms-auto">+ Tambah Transaksi</a>
    </div>

    {{-- Table --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Qty</th>
                <th>Type</th>
                <th>Date</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $loop->iteration + ($transactions->currentPage()-1)*$transactions->perPage() }}</td>

                {{-- Aman kalau produk dihapus --}}
                <td>{{ $t->product->product_code ?? $t->product_code ?? '-' }}</td>
                <td>{{ $t->product->name ?? $t->product_name ?? '-' }}</td>

                <td>{{ $t->description ?? '-' }}</td>
                <td>{{ $t->quantity }}</td>
                <td>
                    @if($t->type == 'in')
                        <span class="badge bg-success">Masuk</span>
                    @else
                        <span class="badge bg-danger">Keluar</span>
                    @endif
                </td>
                <td>{{ $t->date }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Export PDF & Excel --}}
    <div class="mb-3">
        <a href="{{ route('transactions.pdf', request()->only('type','search')) }}" class="btn btn-outline-info" target="_blank">
            Download PDF
        </a>
        <a href="{{ route('transactions.export.excel', request()->only('type','search')) }}" class="btn btn-success">
            Export Excel
        </a>
    </div>

    {{-- Pagination --}}
    {{ $transactions->links() }}
</div>
@endsection
