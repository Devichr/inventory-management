<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EOQCalculation extends Model
{
    use HasFactory;

    protected $table = 'eoq_calculations' ;

    protected $fillable = [
        'fabric_id',
        'annual_demand',
        'order_cost',
        'holding_cost',
        'eoq',
        'total_cost',
        'reorder_point',
        'calculation_date',
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
