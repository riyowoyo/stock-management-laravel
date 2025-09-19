@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ Tambah Transaksi</h3>

    {{-- ✅ Alert error kalau ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Barang</label>
            <select name="product_id" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->product_code }} - {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe Transaksi</label>
            <select name="type" class="form-select" required>
                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Qty</label>
            <input type="number" name="quantity" class="form-control" min="1" 
                   value="{{ old('quantity') }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" 
                   value="{{ old('date') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
