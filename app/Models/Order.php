<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'quantity_ordered',
        'order_date',
        'arrival_date',
        'cost',
    ];

    // Relasi dengan model Fabric
    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
