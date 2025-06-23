<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserHasRole;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name',
        'description'
    ];

    public function permissions(){
        return $this->hasMany(RoleHasPermission::class, 'role_id', 'id');
    }

    public function users(){
        return $this->hasMany(UserHasRole::class, 'role_id', 'id');
    }
}