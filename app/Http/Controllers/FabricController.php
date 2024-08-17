<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fabrics = Fabric::all();
        return view('admin.fabrics.index', compact('fabrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fabrics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:fabrics',
            'initial_stock' => 'required|integer',
            'unit' => 'required|string|max:50',
        ]);

        Fabric::create($request->all());

        return redirect()->route('fabrics.index')->with('success', 'Fabric created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fabric $fabric)
    {
        $fabric->delete();

        return redirect()->route('fabrics.index')->with('success', 'Fabric deleted successfully.');
    }
}
