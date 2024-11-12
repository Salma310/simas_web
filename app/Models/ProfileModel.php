<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;

    protected $table = 'm_profile';
    protected $primaryKey = "profile_id";
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;

    protected $fillable = ['profile_id', 'user_id', 'name', 'nidn','phone', 'avatar'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}
