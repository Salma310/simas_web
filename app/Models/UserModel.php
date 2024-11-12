<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = "user_id";
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;

    protected $fillable = ['user_id', 'username', 'password', 'email', 'name', 'phone', 'avatar', 'role_id', 'auth_token', 'device_token'];

    protected $hidden = ['password']; //jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function role() 
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'role_id');
    } 
    
    public function avatar() : Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/app/public/avatars/' . $image),
        );
    }

    public function hasRole($role) : bool 
    {
        return $this->level->level_kode == $role;
    }

    public function getRoleName() : string 
    {
        return $this->level->level_nama;
    }

    // public function profile()
    // {
    //     return $this->hasOne(ProfileModel::class, 'user_id', 'user_id');
    // }
}
