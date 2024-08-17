@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="card p-3">
    <h2>Pemesanan Kain Baru</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="fabric_id" class="form-label">Pilih Kain</label>
            <select name="fabric_id" id="fabric_id" class="form-select">
                @foreach($fabrics as $fabric)
                    <option value="{{ $fabric->fabric->id }}">{{ $fabric->fabric->name }} (Stok: {{ $fabric->quantity }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity_ordered" class="form-label">Jumlah Pemesanan</label>
            <input type="number" name="quantity_ordered" id="quantity_ordered" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="order_date" class="form-label">Tanggal Pemesanan</label>
            <input type="date" name="order_date" id="order_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="arrival_date" class="form-label">Tanggal Kedatangan (Opsional)</label>
            <input type="date" name="arrival_date" id="arrival_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cost" class="form-label">Biaya Pemesanan</label>
            <input type="number" name="cost" id="cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Catat Pemesanan</button>
    </form>
</div>
</div>
@endsection
