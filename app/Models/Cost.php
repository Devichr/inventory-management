<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'holding_cost',
        'order_cost',
        'date',
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
