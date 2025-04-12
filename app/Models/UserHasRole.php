<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;

class UserHasRole extends Model
{
    protected $table = 'user_has_roles';
    protected $primaryKey = 'id';
    protected $dates = [];
    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
