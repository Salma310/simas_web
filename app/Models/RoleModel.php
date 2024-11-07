<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'm_role';
    protected $primaryKey = "role_id";
    protected $keyType = 'int';
    public $timestamps =true;
    public $incrementing = true;

    protected $fillable = ['role_id', 'role_kode', 'role_nama'];

    public function user()
    {
        return $this->hasMany(UserModel::class, 'role_id', 'role_id');
    }

}
