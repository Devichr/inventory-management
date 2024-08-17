@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card p-3">
    <h1>{{ isset($stock) ? 'Edit' : 'Add' }} Stock</h1>
    <form action="{{ isset($stock) ? route('stocks.update', $stock->id) : route('stocks.store') }}" method="POST">
        @csrf
        @if(isset($stock))
        @method('PUT')
        @endif
        <div class="mb-3">
            <label for="fabric_id" class="form-label">Fabric</label>
            <select name="fabric_id" id="fabric_id" class="form-control" required>
                <option value="">Select Fabric</option>
                @foreach($fabrics as $fabric)
                <option value="{{ $fabric->id }}" {{ isset($stock) && $stock->fabric_id == $fabric->id ? 'selected' : '' }}>{{ $fabric->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ isset($stock) ? $stock->quantity : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="reorder_point" class="form-label">Reorder Point</label>
            <input type="number" name="reorder_point" id="reorder_point" class="form-control" value="{{ isset($stock) ? $stock->reorder_point : '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($stock) ? 'Update' : 'Add' }}</button>
    </form>
</div>
</div>
@endsection
