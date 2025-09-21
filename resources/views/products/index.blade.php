@extends('layouts.app')

@section('title', 'Master Barang')

@section('content')

    <div class="container-fluid px-4"> <!-- Bikin konten fit dengan layout -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Daftar Barang</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Barang
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <div class="mb-4">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari berdasarkan kode atau nama produk..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data Responsif -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.stock-card', $product->id) }}"
                                                class="btn btn-sm btn-info text-white" title="Kartu Stok"><i
                                                    class="bi bi-file-earmark-text"></i></a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning"
                                                title="Edit"><i class="bi bi-pencil-square"></i></a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $product->id }}" title="Hapus"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Konfirmasi
                                                        Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus barang
                                                    <strong>{{ $product->name }}</strong>? Tindakan ini tidak dapat dibatalkan.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada data barang yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection