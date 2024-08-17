<!DOCTYPE html>
<html>
<head>
    <title>Costs Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<h1>Laporan Biaya dan Penggunaan Kain</h1>

<h2>Biaya Penyimpanan dan Pemesanan</h2>
<table>
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
<table>
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
<table>
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
