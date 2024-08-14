@extends('layouts.admin')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center">Create Order</h3>
            <form method="POST" action="{{ route('orders.admin.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <select class="form-select" id="product_name" name="product_name" required>
                        <option value="" disabled selected>Select Product</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->fabric_type }} (Available: {{ $stock->quantity }})</option>
                        @endforeach
                    </select>
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
