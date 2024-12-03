<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 't_agenda';
    protected $primaryKey = 'agenda_id';
    protected $fillable = ['event_id', 'nama_agenda', 'start_date','end_date', 'tempat', 'point_beban_kerja', 'status', 'jabatan_id'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function assignees()
    {
        return $this->hasMany(AgendaAssignee::class);
    }

    public function documents()
    {
        return $this->hasMany(AgendaDocument::class, 'agenda_id');
    }

    public function workloads()
    {
        return $this->hasMany(Workload::class);
    }

    public function position()
    {
        return $this->BelongsToMany(Position::class, 'jabatan_id');
    }
}
