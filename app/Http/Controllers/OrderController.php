<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }
    public function order()
    {
        $orders = Order::all();
        return view('orders', compact('orders'));
    }

    public function showEOQForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('orders.eoq', compact('order'));
    }

    public function calculateEOQ(Request $request, $orderId)
    {
        $request->validate([
            'demand_rate' => 'required|numeric',
            'ordering_cost' => 'required|numeric',
            'holding_cost' => 'required|numeric',
        ]);

        $D = $request->input('demand_rate'); // Annual demand rate
        $S = $request->input('ordering_cost'); // Ordering cost per order
        $H = $request->input('holding_cost'); // Holding cost per unit per year

        // Formula EOQ: √(2DS/H)
        $EOQ = sqrt((2 * $D * $S) / $H);

        $order = Order::findOrFail($orderId);
        $order->eoq = $EOQ;
        $order->save();

        return view('orders.eoq', compact('order', 'EOQ'))->with('status', 'EOQ calculated and saved.');
    }

}
