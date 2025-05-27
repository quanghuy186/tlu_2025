<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('forum_categories')->insert([
            [
                'name' => 'Thảo luận học tập',
                'slug' => 'hoc-tap',
                'description' => 'Nơi trao đổi về các môn học, tài liệu và kiến thức',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tài liệu & Đề thi cũ',
                'slug' => 'tai-lieu-de-thi-cu',
                'description' => 'Chia sẻ tài liệu, giáo trình, đề cương, đề thi',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kỹ thuật xây dựng',
                'slug' => 'ky-thuat-xay-dung',
                'description' => 'Trao đổi về chuyên ngành Kỹ thuật Xây dựng',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Công nghệ thông tin',
                'slug' => 'cong-nghe-thong-tin',
                'description' => 'Mọi thứ liên quan đến ngành CNTT',
                'parent_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đời sống sinh viên',
                'slug' => 'doi-song-sinh-vien',
                'description' => 'Tâm sự, hỏi đáp, chia sẻ kinh nghiệm sống',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhà trọ & Ký túc xá',
                'slug' => 'nha-tro-ky-tuc-xa',
                'description' => 'Chia sẻ thông tin, review về chỗ ở quanh trường',
                'parent_id' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Câu lạc bộ - Đội nhóm',
                'slug' => 'cau-lac-bo-doi-nhom',
                'description' => 'Nơi sinh hoạt, giới thiệu các CLB trong trường',
                'parent_id' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hỏi đáp - Tư vấn',
                'slug' => 'hoi-dap-tu-van',
                'description' => 'Cần giải đáp về học tập, thủ tục, học phí,...',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thông báo từ Ban quản trị',
                'slug' => 'thong-bao-bqt',
                'description' => 'Thông báo, nội quy, cập nhật từ BQT diễn đàn',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 0,
                'name' => 'Chưa phân loại',
                'slug' => 'chua-phan-loai',
                'description' => 'Danh mục mặc định cho các bài viết chưa được gán vào danh mục cụ thể.',
                'parent_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
