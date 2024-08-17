<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'quantity_used',
        'date',
        'remaining_stock',
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
