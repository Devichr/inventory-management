@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Edit Stock</h2>
        <form action="{{ route('admin.stock.update', $stock->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="fabric_type" class="form-label">Fabric Type</label>
                <input type="text" class="form-control" id="fabric_type" name="fabric_type" value="{{ $stock->fabric_type }}" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $stock->quantity }}" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $stock->location }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Stock</button>
        </form>
    </div>
@endsection
