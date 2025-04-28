<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        

        $rootDeptId = DB::table('departments')->insertGetId([
            'name' => 'Trường Đại học Thủy Lợi',
            'code' => 'TLU',
            'parent_id' => null,  // Sử dụng NULL thay vì 0
            'user_id' => null,//User::inRandomOrder()->first()->id,
            'description' => $faker->paragraph,
            'phone' => $faker->numerify('024########'),
            'email' => 'contact@tlu.edu.vn',
            'address' => '175 Tây Sơn, Đống Đa, Hà Nội',
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Tạo đơn vị cấp 2 (khoa, phòng ban)
        $level2Names = [
            'Khoa Công nghệ Thông tin' => 'CNTT',
            'Khoa Điện - Điện tử' => 'DDT',
            'Khoa Kinh tế và Quản lý' => 'KT',
            'Khoa Kỹ thuật Xây dựng' => 'XD',
            'Phòng Đào tạo' => 'PDT',
            'Phòng Tài chính - Kế toán' => 'TCKT',
            'Phòng Công tác Sinh viên' => 'CTSV',
            'Phòng Khoa học Công nghệ' => 'KHCN'
        ];
        
        $level2Ids = [];
        
        foreach ($level2Names as $name => $code) {
            $level2Ids[] = DB::table('departments')->insertGetId([
                'name' => $name,
                'code' => $code,
                'parent_id' => $rootDeptId,
                'user_id' => null,//User::inRandomOrder()->first()->id,
                'description' => $faker->paragraph,
                'phone' => $faker->numerify('024########'),
                'email' => strtolower($code) . '@tlu.edu.vn',
                'address' => $faker->address,
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Tạo đơn vị cấp 3 (bộ môn, văn phòng)
        $level3Units = [
            'Bộ môn Công nghệ phần mềm' => ['code' => 'CNPM', 'parent_index' => 0],
            'Bộ môn Hệ thống thông tin' => ['code' => 'HTTT', 'parent_index' => 0],
            'Bộ môn Khoa học máy tính' => ['code' => 'KHMT', 'parent_index' => 0],
            'Bộ môn Kỹ thuật điện' => ['code' => 'KTD', 'parent_index' => 1],
            'Bộ môn Tự động hóa' => ['code' => 'TDH', 'parent_index' => 1],
            'Bộ môn Quản trị kinh doanh' => ['code' => 'QTKD', 'parent_index' => 2],
            'Bộ môn Kinh tế' => ['code' => 'KTE', 'parent_index' => 2],
            'Bộ môn Kết cấu công trình' => ['code' => 'KCCT', 'parent_index' => 3],
            'Bộ môn Thủy lực' => ['code' => 'TL', 'parent_index' => 3],
            'Văn phòng Khoa CNTT' => ['code' => 'VP-CNTT', 'parent_index' => 0],
            'Văn phòng Khoa Điện - Điện tử' => ['code' => 'VP-DDT', 'parent_index' => 1],
            'Văn phòng Đào tạo Đại học' => ['code' => 'DT-DH', 'parent_index' => 4],
            'Văn phòng Đào tạo Sau đại học' => ['code' => 'DT-SDH', 'parent_index' => 4],
        ];
        
        foreach ($level3Units as $name => $info) {
            DB::table('departments')->insert([
                'name' => $name,
                'code' => $info['code'],
                'parent_id' => $level2Ids[$info['parent_index']],
                'user_id' => null,//User::inRandomOrder()->first()->id,
                'description' => $faker->paragraph,
                'phone' => $faker->numerify('024########'),
                'email' => strtolower(str_replace('-', '', $info['code'])) . '@tlu.edu.vn',
                'address' => $faker->address,
                'level' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
