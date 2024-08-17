<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'predicted_demand',
        'prediction_date',
    ];

    // Relasi dengan model Fabric
    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
