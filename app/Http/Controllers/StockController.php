<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('fabric')->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $fabrics = Fabric::all();
        return view('stocks.create', compact('fabrics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fabric_id' => 'required|exists:fabrics,id',
            'quantity' => 'required|integer',
            'reorder_point' => 'required|integer',
        ]);

        Stock::create($request->all());
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully');
    }

    public function edit(Stock $stock)
    {
        $fabrics = Fabric::all();
        return view('stocks.edit', compact('stock', 'fabrics'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'fabric_id' => 'required|exists:fabrics,id',
            'quantity' => 'required|integer',
            'reorder_point' => 'required|integer',
        ]);

        $stock->update($request->all());
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully');
    }
}
