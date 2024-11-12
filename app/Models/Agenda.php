<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 't_agenda';
    protected $primaryKey = 'agenda_id';
    protected $fillable = ['event_id', 'nama_agenda', 'waktu', 'tempat', 'point_beban_kerja'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function assignees()
    {
        return $this->hasMany(AgendaAssignee::class);
    }

    public function documents()
    {
        return $this->hasMany(AgendaDocument::class);
    }

    public function workloads()
    {
        return $this->hasMany(Workload::class);
    }
}
