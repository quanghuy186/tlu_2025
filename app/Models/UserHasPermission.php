<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;
class UserHasPermission extends Model
{
    protected $table = 'user_has_permissions';
    protected $primaryKey = 'id';
    protected $dates = [];
    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
