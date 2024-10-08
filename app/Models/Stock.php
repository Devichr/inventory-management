<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'quantity',
        'reorder_point',
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
