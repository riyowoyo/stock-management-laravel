@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body py-3">
            <h5 class="mb-0 fw-bold">✏️ Edit Transaksi</h5>
        </div>
        <div class="card-body">

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="product_id" class="form-label">Barang</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ $transaction->product_id == $p->id ? 'selected' : '' }}>
                                {{ $p->product_code }} - {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Tipe Transaksi</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                        <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Qty</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ $transaction->quantity }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ $transaction->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $transaction->date }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
