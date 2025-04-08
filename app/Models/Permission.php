<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'permission_name',
        'description'
    ];

    public function permissions(){
        return $this->hasMany(RoleHasPermission::class, 'permission_id', 'id');
    }


}