<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('admin.stock', compact('stocks'));
    }
    public function stock()
    {
        $stocks = Stock::all();
        return view('stock', compact('stocks'));
    }

    public function showAddStockForm()
    {
        return view('admin.add-stock');
    }

    public function storeStock(Request $request)
    {
        $request->validate([
            'fabric_type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'location' => 'required|string|max:255',
        ]);

        Stock::create($request->all());

        return redirect()->route('admin.stock')->with('success', 'Stock updated successfully');
    }

    public function editStock($id)
    {
        $stock = Stock::findOrFail($id);
        return view('admin.edit-stock', compact('stock'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'fabric_type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'location' => 'required|string|max:255',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->update($request->all());

        return redirect()->route('admin.stock')->with('success', 'Stock updated successfully');
    }
}

