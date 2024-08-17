<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EoqCalculation;
use App\Models\Fabric;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Notification;
use App\Models\FabricUsage;
use Illuminate\Support\Facades\Auth;
use App\Models\Prediction;

class DashboardController extends Controller
{
    public function index()
    {
    $user = Auth::user();
    $orderThisWeek = Order::whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $ordersCount = Order::count();
    $stockCount = Stock::sum('quantity');
    $fabricCount = Fabric::count();
    $usageSum = FabricUsage::sum('quantity_used');

    // Get data for charts
    $orders = Order::selectRaw('MONTH(order_date) as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->pluck('count', 'month')
                    ->toArray();

    $stockIn = Stock::selectRaw('MONTH(created_at) as month, SUM(quantity) as total')
                    ->groupBy('month')
                    ->pluck('total', 'month')
                    ->toArray();

    $thisMonthOrders = Order::whereMonth('order_date', now()->month)->count();
    $lastMonthOrders = Order::whereMonth('order_date', now()->subMonth()->month)->count();

        $usageData = FabricUsage::selectRaw('MONTH(created_at) as month, SUM(quantity_used) as count')
                                  ->groupBy('month')
                                  ->pluck('count', 'month');

        $orderData = Order::selectRaw('MONTH(created_at) as month, SUM(quantity_ordered) as count')
                          ->groupBy('month')
                          ->pluck('count', 'month');

        // Data untuk chart pertumbuhan stok
        $lastMonthStock = Stock::whereMonth('created_at', now()->subMonth()->month)
                                ->sum('quantity');

        $thisMonthStock = Stock::whereMonth('created_at', now()->month)
                               ->sum('quantity');

    // Calculate Reorder Point Notification and insert into notifications table
    $lowStocks = Stock::with('fabric')->get()->filter(function ($stock) {
        $eoq = EoqCalculation::where('fabric_id', $stock->fabric_id)->latest()->first();
        return $eoq && $stock->quantity <= $eoq->reorder_point;
    });

    foreach ($lowStocks as $stock) {
        $notificationMessage = "{$stock->fabric->name} is low on stock. Current quantity: {$stock->quantity}. Reorder Point: {$stock->eoq_calculation->reorder_point}";

        Notification::create([
            'type' => 'Reorder Point Alert',
            'message' => $notificationMessage,
        ]);
    }

    // Fetch unread notifications
    $notifications = Notification::where('is_read', false)->get();
    $predictions = Prediction::with('fabric')->get();

    return view('dashboard', compact(
        'user',
        'orderThisWeek',
        'ordersCount',
        'stockCount',
        'fabricCount',
        'orders',
        'stockIn',
        'thisMonthOrders',
        'lastMonthOrders',
        'notifications',
        'usageData',
        'orderData',
        'lastMonthStock',
        'thisMonthStock',
        'usageSum',
        'predictions'
    ));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsReadAndDelete();

        return redirect()->back();
    }
}
