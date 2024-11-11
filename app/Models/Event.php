<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'm_event';
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_name', 'event_description', 'start_date', 'end_date', 'status', 'assign_letter', 'jenis_event_id'];

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'jenis_event_id');
    }
}
