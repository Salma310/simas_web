<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaioms(){
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = "user_id";
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;

    protected $fillable = ['user_id', 'username', 'password', 'email', 'role_id', 'auth_token', 'device_token'];

    protected $hidden = ['password']; //jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function role() 
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'role_id');
    } 
    
    public function profile()
    {
        return $this->hasOne(ProfileModel::class, 'user_id', 'user_id');
    }
}
