<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaAssignee extends Model
{
    use HasFactory;

    protected $table = 'agenda_assignee';
    protected $fillable = ['agenda_id', 'user_id', 'jabatan_id', 'document_progress'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }
}
