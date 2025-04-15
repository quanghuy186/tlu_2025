<?php

use Illuminate\Support\Facades\DB;
function tluHasPermission($user, $permission){
        $email = $user->email;
        $result1 = 0;
        $result2 = 0;
        $result = 0;   

        //check role
        $result1 = DB::table("users")
        ->join("user_has_roles","user_has_roles.user_id","=","users.id")
        ->join("role_has_permissions","user_has_roles.role_id","=","role_has_permissions.role_id")
        ->join("permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where('users.email',"=", $email)
        ->where('permissions.permission_name', '=', $permission)
        ->count();
        
        //check permission
        if($result1 <= 0){
            $result2 = DB::table("users")
            ->join("user_has_permissions","user_has_permissions.user_id","=","users.id")
            ->join("permissions","user_has_permissions.permission_id","=","permissions.id")
            ->where('users.email',"=", $email)
            ->where('permissions.permission_name', '=', $permission)
            ->count();
        }
        $result = $result1 + $result2;
        $hasPermission = $result > 0;
        return $hasPermission;
}