<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable; 


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;
    protected $fillable =
    [
        'username', 'email', 'password', 'auth_token', 'device_token', 'name', 'phone', 'picture', 'role_id'
    ];

    protected $hidden = ['password']; //jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function avatar() : Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/app/public/picture/' . $image),
        );
    }

    public function profil()
    {
        return $this->hasOne(Profil::class);
    }


    public function eventParticipant()
    {
        return $this->hasMany(EventParticipant::class, 'user_id', 'user_id');
    }

    public function agendaAssignees()
    {
        return $this->hasMany(AgendaAssignee::class);
    }

    public function workloads()
    {
        return $this->hasMany(Workload::class);
    }

}
