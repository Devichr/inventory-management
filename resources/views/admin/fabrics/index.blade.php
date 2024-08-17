@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Fabrics</h1>
            <a href="{{ route('fabrics.create') }}" class="btn btn-primary">Create New Fabric</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>SKU</th>
                <th>Initial Stock</th>
                <th>Unit</th>
                <th>Action</th>
            </tr>
            @foreach ($fabrics as $fabric)
                <tr>
                    <td>{{ $fabric->name }}</td>
                    <td>{{ $fabric->sku }}</td>
                    <td>{{ $fabric->initial_stock }}</td>
                    <td>{{ $fabric->unit }}</td>
                    <td>

                        <form action="{{ route('fabrics.destroy', $fabric->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    </div>
@endsection
