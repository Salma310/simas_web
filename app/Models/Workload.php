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

    // Di model Workload jika nama kolom berbeda
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // ganti 'user_id' jika nama kolom berbeda
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
