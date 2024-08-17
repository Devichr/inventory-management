<?php

namespace App\Http\Controllers;

use App\Models\EOQCalculation;
use App\Models\Fabric;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class EOQCalculationController extends Controller
{
    public function create()
    {
        $fabrics = Fabric::all();
        return view('eoq.create', compact('fabrics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fabric_id' => 'required|exists:fabrics,id',
            'annual_demand' => 'required|integer',
            'order_cost' => 'required|numeric',
            'holding_cost' => 'required|numeric',
        ]);

        // Hitung EOQ
        $eoq = sqrt((2 * $request->annual_demand * $request->order_cost) / $request->holding_cost);

        // Hitung biaya total
        $total_cost = ($eoq * $request->order_cost) + (($request->annual_demand / $eoq) * $request->holding_cost);

        // Hitung Reorder Point
        $reorder_point = ($request->annual_demand / 365) * 7; // Asumsi lead time adalah 7 hari

        // Simpan hasil perhitungan ke tabel eoq_calculations
        $eoqCalculation = EOQCalculation::create([
            'fabric_id' => $request->fabric_id,
            'annual_demand' => $request->annual_demand,
            'order_cost' => $request->order_cost,
            'holding_cost' => $request->holding_cost,
            'eoq' => $eoq,
            'total_cost' => $total_cost,
            'reorder_point' => $reorder_point,
            'calculation_date' => now(),
        ]);

        // Update stok di tabel stocks
        $stock = Stock::where('fabric_id', $request->fabric_id)->first();
        if ($stock) {
            $stock->update([
                'reorder_point' => $reorder_point,
            ]);
        }

        // Cek stok saat ini dan kirim notifikasi jika diperlukan
        if ($stock->quantity <= $reorder_point) {
            Notification::create([
                'message' => "Stok kain '{$stock->fabric->name}' mendekati titik pemesanan ulang!",
                'is_read' => false,
            ]);
        }

        return redirect()->route('eoq.index')->with('success', 'Perhitungan EOQ berhasil disimpan.');
    }
}
