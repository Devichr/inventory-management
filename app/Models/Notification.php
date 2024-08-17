<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsReadAndDelete()
    {
        $this->update(['is_read' => true]);

        // Delete the notification if it's marked as read
        if ($this->is_read) {
            $this->delete();
        }
    }
}
