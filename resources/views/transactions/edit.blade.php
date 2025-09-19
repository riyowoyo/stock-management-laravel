@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ Edit Transaksi</h3>
    
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

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Barang</label>
            <select name="product_id" class="form-select" required>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ $transaction->product_id == $p->id ? 'selected' : '' }}>
                        {{ $p->code }} - {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe Transaksi</label>
            <select name="type" class="form-select" required>
                <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Barang Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Qty</label>
            <input type="number" name="quantity" class="form-control" value="{{ $transaction->quantity }}" min="1" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $transaction->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ $transaction->date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
