<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricUsage;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PredictionController extends Controller
{
    public function generatePredictions()
    {
        $fabrics = Fabric::all();

        foreach ($fabrics as $fabric) {
            $usages = FabricUsage::where('fabric_id', $fabric->id)
                ->where('date', '>=', Carbon::now()->subYear())
                ->orderBy('date')
                ->get();

            if ($usages->count() > 0) {
                $totalUsage = $usages->sum('quantity_used');
                $averageUsage = $totalUsage / $usages->count();
                $predictedDemand = round($averageUsage * 12); // Prediksi tahunan

                // Simpan prediksi ke tabel predictions
                Prediction::updateOrCreate(
                    ['fabric_id' => $fabric->id, 'prediction_date' => Carbon::now()->toDateString()],
                    ['predicted_demand' => $predictedDemand]
                );
            }
        }

        return redirect()->route('dashboard')->with('success', 'Predictions updated successfully.');
    }
}

