@extends('layouts.admin')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center">Tambah Penggunaan kain</h3>
            <form method="POST" action="{{ route('usage.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="stock_id" class="form-label">Product Name</label>
                    <select class="form-select" id="stock_id" name="stock_id" required>
                        <option value="" disabled selected>Select Product</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->fabric_type }} (Available: {{ $stock->quantity }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" required >
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Order</button>
            </form>
        </div>
    </div>
</div>
@endsection
