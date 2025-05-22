<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        DB::table('roles')->insert([
            [
                'id' => 1,
                'role_name' => 'sinh_vien',
                'description' => 'Sinh viên (Student)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'role_name' => 'giang_vien',
                'description' => 'Giảng viên (Teacher)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'role_name' => 'don_vi',
                'description' => 'Đơn vị (Department)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 999,
                'role_name' => 'admin',
                'description' => 'Quản trị viên (admin)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
