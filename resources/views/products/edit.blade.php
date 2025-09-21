@extends('layouts.app')

@section('title', 'Edit Barang - ' . $product->name)

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Edit Barang</h5>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="product_code" class="form-label">Kode Barang</label>
                    <input type="text" id="product_code" name="product_code" 
                           class="form-control @error('product_code') is-invalid @enderror" 
                           value="{{ old('product_code', $product->product_code) }}" required>
                    @error('product_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Barang</label>
                    <input type="text" id="name" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" id="unit" name="unit" 
                           class="form-control @error('unit') is-invalid @enderror" 
                           value="{{ old('unit', $product->unit) }}" required>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" id="price" name="price" 
                           class="form-control @error('price') is-invalid @enderror" 
                           value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Update
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
