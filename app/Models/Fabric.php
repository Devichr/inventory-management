<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'initial_stock',
        'unit'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'fabric_type', 'id');
    }

    public function eoqCalculations()
    {
        return $this->hasMany(EoqCalculation::class, 'fabric_type', 'id');
    }

    public function fabricUsages()
    {
        return $this->hasMany(FabricUsage::class, 'fabric_type', 'id');
    }
}
