@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3">
            <h5 class="mb-0 fw-bold">Tambah Barang Baru</h5>
        </div>
        <div class="card-body">

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Ada kesalahan pada input.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="product_code" class="form-label">Kode Barang</label>
                    <input type="text" name="product_code" class="form-control" id="product_code" value="{{ old('product_code') }}" placeholder="Masukkan kode barang" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Barang</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Masukkan nama barang" required>
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Satuan</label>
                    <input type="text" name="unit" class="form-control" id="unit" value="{{ old('unit') }}" placeholder="pcs, box, dll" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" placeholder="Masukkan harga satuan" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
