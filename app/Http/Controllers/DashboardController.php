<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Stock;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersCount = Order::count();
        $stockCount = Stock::count();

        $orders = Order::selectRaw('MONTH(created_at) as month, SUM(quantity) as total_orders')
        ->groupBy('month')
        ->pluck('total_orders', 'month');

        $startOfWeek = Carbon::now()->startOfWeek(); // Minggu dimulai dari hari Senin
        $endOfWeek = Carbon::now()->endOfWeek(); // Minggu berakhir pada hari Minggu

        // Mengambil jumlah order baru minggu ini
        $orderThisWeek = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        $stockIn = Stock::selectRaw('MONTH(created_at) as month, SUM(quantity) as total_stock_in')
        ->groupBy('month')
        ->pluck('total_stock_in', 'month');

        $ordersGrowth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $lastMonthOrders = Order::whereMonth('created_at', '=', now()->subMonth()->month)->count();
        $thisMonthOrders = Order::whereMonth('created_at', '=', now()->month)->count();


        return view('dashboard', compact('ordersCount', 'stockCount' ,'orders','stockIn','orderThisWeek','ordersGrowth','lastMonthOrders','thisMonthOrders'));
    }
}


