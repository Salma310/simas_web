<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 't_notification';
    protected $primaryKey = 'notification_id';
    protected $fillable = ['user_id', 'event_id', 'agenda_id', 'title', 'message', 'type', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
