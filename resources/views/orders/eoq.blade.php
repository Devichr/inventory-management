@extends('layouts.admin')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('orders.eoq.calculate') }}">
        @csrf
        <div class="mb-3">
            <label for="demand_rate" class="form-label">Annual Demand Rate (D)</label>
            <input type="number" name="demand_rate" id="demand_rate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="ordering_cost" class="form-label">Ordering Cost per Order (S)</label>
            <input type="number" name="ordering_cost" id="ordering_cost" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="holding_cost" class="form-label">Holding Cost per Unit per Year (H)</label>
            <input type="number" name="holding_cost" id="holding_cost" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Calculate EOQ</button>
    </form>

    @isset($EOQ)
        <h2>EOQ: {{ $EOQ }}</h2>
    @endisset
</div>
@endsection
