<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaioms(){
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username', 'email', 'password', 'auth_token', 'device_token', 'name', 'phone', 'picture',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
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
