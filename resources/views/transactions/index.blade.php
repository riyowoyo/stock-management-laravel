@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Transaksi</h5>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                + Tambah Transaksi
            </a>
        </div>
        <div class="card-body">

            {{-- Search --}}
            <form action="{{ route('transactions.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Kode/Nama/Deskripsi" value="{{ request('search') }}">
                <button class="btn btn-primary">Cari</button>
            </form>

            {{-- Filter --}}
            <div class="mb-3 d-flex gap-2 flex-wrap">
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-dark {{ request('type') ? '' : 'active' }}">Semua</a>
                <a href="{{ route('transactions.index', ['type' => 'in']) }}" class="btn btn-outline-success {{ request('type') == 'in' ? 'active' : '' }}">Barang Masuk</a>
                <a href="{{ route('transactions.index', ['type' => 'out']) }}" class="btn btn-outline-danger {{ request('type') == 'out' ? 'active' : '' }}">Barang Keluar</a>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Deskripsi</th>
                            <th>Qty</th>
                            <th>Type</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr>
                            <td>{{ $loop->iteration + ($transactions->currentPage()-1)*$transactions->perPage() }}</td>
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
                            <td class="text-center">
                                <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>

                                <!-- Modal Hapus -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $t->id }}">
                                    Hapus
                                </button>

                                <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $t->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('transactions.destroy', $t->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $t->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Yakin ingin menghapus transaksi <strong>{{ $t->description }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Export --}}
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <a href="{{ route('transactions.pdf', request()->only('type','search')) }}" class="btn btn-outline-info" target="_blank">Download PDF</a>
                <a href="{{ route('transactions.export.excel', request()->only('type','search')) }}" class="btn btn-success">Export Excel</a>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
