<?php

namespace App\Http\Controllers;

use App\Models\FabricUsage;
use App\Models\Stock;
use App\Models\Notification;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FabricUsageController extends Controller
{
    private function calculateHoldingCost(FabricUsage $fabricUsage)
{
    {
        // Ambil jumlah kain tersisa setelah penggunaan
        $remainingStock = $fabricUsage->remaining_stock;

        // Biaya penyimpanan per unit per bulan
        $holdingCostPerUnit = 10000; // Contoh biaya Rp 10.000 per meter per bulan

        // Asumsikan periode penyimpanan dalam bulan
        $storagePeriod = 1; // 1 bulan

        // Hitung holding cost
        $holdingCost = $remainingStock * $holdingCostPerUnit * $storagePeriod;

        return $holdingCost;
    }
}

    public function create()
    {
        $fabrics = Stock::with('fabric')->get();
        return view('fabric_usage.create', compact('fabrics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fabric_id' => 'required|exists:stocks,fabric_id',
            'quantity_used' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $stock = Stock::where('fabric_id', $request->fabric_id)->first();

        if ($stock->quantity < $request->quantity_used) {
            return redirect()->back()->withErrors(['quantity_used' => 'Jumlah penggunaan melebihi stok yang tersedia.']);
        }

        $remaining_stock = $stock->quantity - $request->quantity_used;

        $fabricUsage = FabricUsage::create([
            'fabric_id' => $request->fabric_id,
            'quantity_used' => $request->quantity_used,
            'date' => $request->date,
            'remaining_stock' => $remaining_stock,
        ]);

        $stock->update(['quantity' => $remaining_stock]);

        if ($stock->quantity <= $stock->reorder_point) {
            Notification::create([
                'user_id' => Auth::user()->id,
                'message' => "Stok kain '{$stock->fabric->name}' mendekati titik pemesanan ulang!",
                'is_read' => false,
            ]);
        }

            // Hitung holding cost atau biaya penyimpanan berdasarkan stok kain yang tersisa
    $holdingCost = $this->calculateHoldingCost($fabricUsage);

    // Simpan biaya penggunaan ke dalam tabel costs
    Cost::create([
        'fabric_id' => $fabricUsage->fabric_id,
        'order_cost' => 0, // Asumsikan ini adalah biaya penggunaan, tidak ada order cost
        'holding_cost' => $holdingCost,
        'date' => $fabricUsage->date,
    ]);

        return redirect()->route('dashboard')->with('success', 'Penggunaan kain berhasil dicatat.');
    }

    public function index()
    {
        $usages = FabricUsage::with('fabric')->get();
        return view('fabric_usage.index', compact('usages'));
    }
}
