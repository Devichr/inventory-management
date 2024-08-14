<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('user.history', compact('orders'));
    }

    public function contactAdmin()
    {
        return view('user.contact-admin');
    }

    public function sendContactAdmin(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Kirim email ke admin (contoh: admin@inventory.com)
        Mail::raw($request->message, function ($message) {
            $message->to('admin@inventory.com')
                    ->subject('Message from User');
        });

        return redirect()->route('dashboard')->with('status', 'Message sent to admin.');
    }

    public function contactUser($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.contact-user', compact('user'));
    }

    public function sendContactUser(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = User::findOrFail($userId);

        // Kirim email ke user
        Mail::raw($request->message, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Message from Admin');
        });

        return redirect()->route('admin.orders')->with('status', 'Message sent to user.');
    }

    public function createOrder()
    {
        $stocks = Stock::all();
        return view('user.create-order', compact('stocks'));
    }

    public function storeOrder(Request $request)
{
    $request->validate([
        'product_name' => 'required|exists:stocks,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $stock = Stock::find($request->product_name);
    $orderQuantity = $request->quantity;

    if ($stock->quantity >= $orderQuantity) {
        $status = 'completed';
        $stock->quantity -= $orderQuantity;
        $stock->save();
    } else {
        $status = 'pending';
        $remainingOrder = $orderQuantity - $stock->quantity;
        $stock->quantity = 0;
        $stock->save();
        $orderQuantity = $remainingOrder;
    }

    Order::create([
        'user_id' => Auth::user()->id,
        'product_name' => $stock->fabric_type,
        'quantity' => $orderQuantity,
        'status' => $status,
    ]);

    return redirect()->route('orders.admin')->with('success', 'Order created successfully');
}
}
