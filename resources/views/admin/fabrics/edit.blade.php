@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Fabric</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fabrics.update', $fabric->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="fabric_type" class="form-label">Jenis Kain</label>
                <input type="text" class="form-control" id="fabric_type" name="fabric_type" value="{{ $fabric->name }}" required disabled>
            </div>

            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="{{ $fabric->sku }}" required disabled>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Stok</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $fabric->initial_stock }}" required >
            </div>


            <div class="mb-3">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" class="form-control" id="unit" name="unit" value="{{ $fabric->unit }}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
