@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="card p-3">
        <h1>Create New Fabric</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stocks.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}" required>
            </div>

            <div class="mb-3">
                <label for="initial_stock" class="form-label">Initial Stock</label>
                <input type="number" class="form-control" id="initial_stock" name="initial_stock" value="{{ old('initial_stock') }}" required>
            </div>

            <div class="mb-3">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
@endsection
