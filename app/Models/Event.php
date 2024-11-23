<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'm_event';
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_name', 'event_code', 'event_description', 'start_date', 'end_date', 'status', 'assign_letter', 'jenis_event_id'];

    public function participants()
    {
        return $this->hasMany(EventParticipant::class, 'event_id');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'agenda_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notification_id');
    }

    public function jenisEvent()
    {
        return $this->belongsTo(EventType::class, 'jenis_event_id');
    }
}
