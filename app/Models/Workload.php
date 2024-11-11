<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workload extends Model
{
    use HasFactory;

    protected $table = 't_workload';
    protected $primaryKey = 'workload_id';
    protected $fillable = ['agenda_id', 'user_id', 'earned_points', 'period'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
