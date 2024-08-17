@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="card p-3">
    <h2>Catat Penggunaan Kain</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fabric_usage.store') }}" method="POST">
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
            <label for="quantity_used" class="form-label">Jumlah Penggunaan</label>
            <input type="number" name="quantity_used" id="quantity_used" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Tanggal Penggunaan</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Catat Penggunaan</button>
    </form>
    </div>
</div>
@endsection
