<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionSeeder extends Seeder
{
  
    public function run(): void
    {
        $permissionNames = [
            'view-detail-teacher',
            'view-detail-student',
            'view-detail-department',
            'create-notification',
            'show-anonymously',
            'show-anonymously-comment'
        ];
        
        $permissions = DB::table('permissions')
            ->whereIn('permission_name', $permissionNames)
            ->select('id')
            ->get();
        
        $rolePermissions = [];
        
        foreach ($permissions as $permission) {
            $rolePermissions[] = [
                'role_id' => 3,
                'permission_id' => $permission->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($permissions as $permission) {
            $rolePermissions[] = [
                'role_id' => 4,
                'permission_id' => $permission->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('role_has_permissions')->insert($rolePermissions);
    }
}