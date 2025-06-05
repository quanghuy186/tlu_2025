<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'permission_name' => 'view-detail-teacher',
                'description' => 'Xem chi tiết thông tin giảng viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'view-detail-student',
                'description' => 'Xem chi tiết thông tin sinh viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'view-detail-department',
                'description' => 'Xem chi tiết thông tin đơn vị',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'create-notification',
                'description' => 'Cho phép tạo thông báo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'show-anonymously',
                'description' => 'Hiển thị thông tin người đăng bài viết trên diễn đàn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'show-anonymously-comment',
                'description' => 'Hiển thị thông tin người bình luận ẩn danh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}