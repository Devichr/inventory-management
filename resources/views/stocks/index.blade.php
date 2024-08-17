@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="card p-3">
    <h1>Stock List</h1>
    <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fabric</th>
                <th>Quantity</th>
                <th>Reorder Point</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock->fabric->name }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->reorder_point }}</td>
                <td>
                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
