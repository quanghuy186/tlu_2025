<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;

class RoleHasPermission extends Model
{
    protected $table = 'role_has_permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_id',
        'permission_id',
    ];
    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission', 'id');
    }
}