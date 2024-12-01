<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'm_event';
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_code', 'event_name', 'event_description', 'assign_letter', 'status', 'start_date', 'end_date',  'jenis_event_id', 'point'];

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

    public function formatEndDate($endDate)
    {
        return Carbon::createFromFormat('YY-MM-DD', $endDate)->format('DD-MM-YY');
    }
}
