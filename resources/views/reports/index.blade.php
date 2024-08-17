@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Laporan Biaya dan Penggunaan Kain</h1>

    <form method="GET" action="{{ route('reports.index') }}">
        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $startDate) }}">
        </div>
        <div class="form-group">
            <label for="end_date">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $endDate) }}">
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
    </form>

    @if($costs->isNotEmpty() || $fabricUsages->isNotEmpty())
    <h2>Biaya Penyimpanan dan Pemesanan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Biaya Penyimpanan</th>
                <th>Biaya Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costs as $cost)
            <tr>
                <td>{{ $cost->date }}</td>
                <td>{{ $cost->holding_cost }}</td>
                <td>{{ $cost->order_cost }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Order Kain</h2>
    <table class="table table-bordered"
        <thead>
            <tr>
                <th>Tanggal Pesan</th>
                <th>Tanggal Datang</th>
                <th>Nama Kain</th>
                <th>Jumlah Dipesan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->arrival_date }}</td>
                <td>{{ $order->fabric->name }}</td>
                <td>{{ $order->quantity_ordered }}</td>
                <td>{{ $order->cost }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Penggunaan Kain</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Kain</th>
                <th>Jumlah Digunakan</th>
                <th>Stok Tersisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fabricUsages as $usage)
            <tr>
                <td>{{ $usage->date }}</td>
                <td>{{ $usage->fabric->name }}</td>
                <td>{{ $usage->quantity_used }}</td>
                <td>{{ $usage->remaining_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate, 'format' => 'excel']) }}" class="btn btn-success">Export ke Excel</a>
    <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate, 'format' => 'pdf']) }}" class="btn btn-danger">Export ke PDF</a>
    @endif
</div>
@endsection
