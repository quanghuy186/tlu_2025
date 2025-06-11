<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notification_categories')->insert([
            [
                'name' => 'Thông báo học vụ',
                'slug' => 'thong-bao-hoc-vu',
                'description' => 'Thông báo về đăng ký môn học, rút/hủy môn, lịch học,...',
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thông báo học bổng',
                'slug' => 'thong-bao-hoc-bong',
                'description' => 'Thông tin về học bổng trong và ngoài trường.',
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lịch thi & thi lại',
                'slug' => 'lich-thi-thi-lai',
                'description' => 'Cập nhật lịch thi giữa kỳ, cuối kỳ và thi lại.',
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tuyển dụng & thực tập',
                'slug' => 'tuyen-dung-thuc-tap',
                'description' => 'Cơ hội việc làm, thực tập cho sinh viên năm cuối.',
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hoạt động sinh viên',
                'slug' => 'hoat-dong-sinh-vien',
                'description' => 'Sự kiện, chương trình ngoại khóa, hội thảo, hội thi.',
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);

        DB::table('notification_categories')->insertOrIgnore([
            [
                'id' => 0,
                'name' => 'Khác',
                'slug' => 'khac',
                'description' => 'Các thông báo khác không thuộc nhóm trên.',
                'display_order' => 99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
