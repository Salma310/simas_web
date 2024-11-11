<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    protected $table = 'event_participants';
    protected $fillable = ['event_id', 'user_id', 'jabatan_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
