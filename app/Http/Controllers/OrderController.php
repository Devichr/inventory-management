<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Cost;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $fabrics = Stock::with('fabric')->get();
        return view('orders.create', compact('fabrics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fabric_id' => 'required|exists:stocks,fabric_id',
            'quantity_ordered' => 'required|integer|min:1',
            'order_date' => 'required|date',
            'arrival_date' => 'nullable|date',
            'cost' => 'required|numeric',
        ]);

        $order = Order::create([
            'fabric_id' => $request->fabric_id,
            'quantity_ordered' => $request->quantity_ordered,
            'order_date' => $request->order_date,
            'arrival_date' => $request->arrival_date,
            'cost' => $request->cost,
        ]);

        // Perbarui stok jika kain telah tiba
        if ($request->arrival_date) {
            $stock = Stock::where('fabric_id', $request->fabric_id)->first();
            $new_quantity = $stock->quantity + $request->quantity_ordered;
            $stock->update(['quantity' => $new_quantity]);
        }

        Cost::create([
            'fabric_id' => $order->fabric_id,
            'order_cost' => $order->cost,
            'holding_cost' => 0, // Asumsikan ini adalah biaya pemesanan awal, tidak ada holding cost
            'date' => $order->order_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pemesanan kain berhasil dicatat.');
    }

    public function index()
    {
        $orders = Order::with('fabric')->get();
        return view('orders.index', compact('orders'));
    }
}
