<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 'm_event';
    protected $primaryKey = "event_id";
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;

    protected $fillable = [
        'event_kode', 
        'event_jenis', 
        'event_name', 
        'event_deskripsi',
        'surat_tugas', 
        'pic', 
        'status',
        'date',
    ];
}
