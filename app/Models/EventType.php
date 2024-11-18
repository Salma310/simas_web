<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $table = 't_jenis_event';
    protected $primaryKey = 'jenis_event_id';
    protected $fillable = ['jenis_event_name', 'jenis_event_code'];

    public function events()
    {
        return $this->hasMany(Event::class, 'jenis_event_id', 'jenis_event_id');
    }
}
