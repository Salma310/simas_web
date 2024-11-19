<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 't_notification';
    protected $primaryKey = 'notification_id';
    protected $fillable = ['event_id', 'title', 'message', 'is_read', 'created_at'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}
