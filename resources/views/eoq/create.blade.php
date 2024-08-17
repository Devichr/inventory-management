
@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="card p-3">
    <h2>Hitung EOQ dan Titik Pemesanan Ulang</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('eoq.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="fabric_id" class="form-label">Pilih Kain</label>
            <select name="fabric_id" id="fabric_id" class="form-select">
                @foreach($fabrics as $fabric)
                    <option value="{{ $fabric->id }}">{{ $fabric->name }} (SKU: {{ $fabric->sku }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="annual_demand" class="form-label">Permintaan Tahunan</label>
            <input type="number" name="annual_demand" id="annual_demand" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="order_cost" class="form-label">Biaya Pemesanan</label>
            <input type="number" name="order_cost" id="order_cost" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="holding_cost" class="form-label">Biaya Penyimpanan</label>
            <input type="number" name="holding_cost" id="holding_cost" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Hitung EOQ</button>
    </form>
</div>
</div>
@endsection
