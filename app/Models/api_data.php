<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class api_data extends Model
{
    use HasFactory;
    protected $table = 't_notification';
    protected $fillable = [
        'event_id',
        'title',
        'message',
        'created_at'
    ];
}
