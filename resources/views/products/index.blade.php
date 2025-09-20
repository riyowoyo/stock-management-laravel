@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Master Barang</h2>

        <div class="mb-3 d-flex">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex w-100">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Kode/Nama Produk"
                    value="{{ request('search') }}">
                <button class="btn btn-primary">Cari</button>
            </form>
        </div>
        
        <!-- Tombol tambah barang -->
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Tambah Barang
            </a>
        </div>

        <!-- Table produk -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Unit</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <!-- Tombol edit -->
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <!-- Tombol delete -->
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $product->id }}">Hapus</button>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus {{ $product->name }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection