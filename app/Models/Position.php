<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'm_jabatan';
    protected $primaryKey = 'jabatan_id';
    protected $fillable = ['jabatan_name', 'jabatan_code'];

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function agendaAssignees()
    {
        return $this->hasMany(AgendaAssignee::class);
    }
}
