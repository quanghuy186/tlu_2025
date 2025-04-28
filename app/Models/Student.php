<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = [
        '',
        ''
    ];

    public function permissions(){
        return $this->hasMany(RoleHasPermission::class, 'role_id', 'id');
    }

    public function users(){
        return $this->hasMany(UserHasRole::class, 'role_id', 'id');
    }
}
