<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
    public function run()
    {
        $departmentUsers = [
            // User cho từng department
            ['id' => 1, 'name' => 'PGS.TS Nguyễn Văn Minh', 'email' => 'hieutruong@tlu.edu.vn', 'phone' => '024.38522201'],
            
            // Level 1 - Trưởng các Khoa
            ['id' => 2, 'name' => 'PGS.TS Trần Thành Công', 'email' => 'truongkhoa.ct@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 3, 'name' => 'TS. Lê Quang Hải', 'email' => 'truongkhoa.kttnr@tlu.edu.vn', 'phone' => '024.38522215'],
            ['id' => 4, 'name' => 'PGS.TS Hoàng Minh Tuấn', 'email' => 'truongkhoa.ck@tlu.edu.vn', 'phone' => '024.38522220'],
            ['id' => 5, 'name' => 'TS. Nguyễn Đức Thành', 'email' => 'truongkhoa.ddt@tlu.edu.vn', 'phone' => '024.38522225'],
            ['id' => 6, 'name' => 'PGS.TS Vũ Thị Lan Anh', 'email' => 'truongkhoa.ktql@tlu.edu.vn', 'phone' => '024.38522230'],
            ['id' => 7, 'name' => 'TS. Phạm Văn Hùng', 'email' => 'truongkhoa.cntt@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 8, 'name' => 'PGS.TS Nguyễn Thị Mai', 'email' => 'truongkhoa.hmt@tlu.edu.vn', 'phone' => '024.38522240'],
            ['id' => 9, 'name' => 'TS. Đỗ Văn Nam', 'email' => 'truongkhoa.lllct@tlu.edu.vn', 'phone' => '024.38522245'],
            ['id' => 10, 'name' => 'TS. Trần Minh Quang', 'email' => 'giamdoc.ttdtqt@tlu.edu.vn', 'phone' => '024.38522250'],
            ['id' => 11, 'name' => 'PGS.TS Lê Thị Hồng', 'email' => 'truongkhoa.ktkd@tlu.edu.vn', 'phone' => '024.38522255'],
            
            // Level 2 - Trưởng các Bộ môn
            ['id' => 12, 'name' => 'TS. Nguyễn Thành Long', 'email' => 'truongbm.tmdt@tlu.edu.vn', 'phone' => '024.38522231'],
            ['id' => 13, 'name' => 'ThS. Phạm Thị Bích', 'email' => 'truongbm.qtdl@tlu.edu.vn', 'phone' => '024.38522232'],
            ['id' => 14, 'name' => 'TS. Lê Văn Dũng', 'email' => 'truongbm.kt@tlu.edu.vn', 'phone' => '024.38522233'],
            ['id' => 15, 'name' => 'TS. Hoàng Thị Linh', 'email' => 'truongbm.ktxd@tlu.edu.vn', 'phone' => '024.38522234'],
            ['id' => 16, 'name' => 'ThS. Vũ Minh Hiếu', 'email' => 'truongbm.ptkn@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 17, 'name' => 'TS. Đặng Văn Toàn', 'email' => 'truongbm.ktkds@tlu.edu.vn', 'phone' => '024.38522236'],
            ['id' => 18, 'name' => 'TS. Nguyễn Thị Phương', 'email' => 'truongbm.lcccu@tlu.edu.vn', 'phone' => '024.38522237'],
            ['id' => 19, 'name' => 'PGS.TS Trần Văn Bình', 'email' => 'giamdoc.ttktql@tlu.edu.vn', 'phone' => '024.38522238'],
            ['id' => 20, 'name' => 'TS. Lê Thị Thu Hà', 'email' => 'truongbm.ktqlmt@tlu.edu.vn', 'phone' => '024.38522241'],
            ['id' => 21, 'name' => 'PGS.TS Nguyễn Văn Tấn', 'email' => 'truongbm.kthh@tlu.edu.vn', 'phone' => '024.38522242'],
            ['id' => 22, 'name' => 'TS. Vũ Thị Lan', 'email' => 'truongbm.cnsh@tlu.edu.vn', 'phone' => '024.38522243'],
            ['id' => 23, 'name' => 'ThS. Đỗ Thị Hương', 'email' => 'truongbm.nna@tlu.edu.vn', 'phone' => '024.38522251'],
            ['id' => 24, 'name' => 'TS. Lý Minh Khang', 'email' => 'truongbm.nntq@tlu.edu.vn', 'phone' => '024.38522252'],
            ['id' => 25, 'name' => 'PGS.TS Phạm Thị Nga', 'email' => 'truongbm.kt2@tlu.edu.vn', 'phone' => '024.38522256'],
            ['id' => 26, 'name' => 'TS. Trần Minh Đức', 'email' => 'truongbm.kta@tlu.edu.vn', 'phone' => '024.38522257'],
            ['id' => 27, 'name' => 'TS. Lê Thị Kim Oanh', 'email' => 'truongbm.tc@tlu.edu.vn', 'phone' => '024.38522258'],
            ['id' => 28, 'name' => 'PGS.TS Nguyễn Văn Khôi', 'email' => 'truongbm.qtkd@tlu.edu.vn', 'phone' => '024.38522259'],
            
            // Level 1 - Trưởng các Phòng ban
            ['id' => 29, 'name' => 'ThS. Hoàng Văn Tùng', 'email' => 'truongphong.hcth@tlu.edu.vn', 'phone' => '024.38522201'],
            ['id' => 30, 'name' => 'ThS. Lê Thị Hoa', 'email' => 'truongphong.tccb@tlu.edu.vn', 'phone' => '024.35633086'],
            ['id' => 31, 'name' => 'PGS.TS Vũ Văn Hiền', 'email' => 'truongphong.dt@tlu.edu.vn', 'phone' => '024.38521441'],
            ['id' => 32, 'name' => 'TS. Đặng Thị Lan', 'email' => 'truongphong.ktdbcl@tlu.edu.vn', 'phone' => '024.35643417'],
            ['id' => 33, 'name' => 'ThS. Nguyễn Minh Sơn', 'email' => 'truongphong.ctctsv@tlu.edu.vn', 'phone' => '024.35639577'],
            ['id' => 34, 'name' => 'TS. Trần Thị Thu', 'email' => 'truongphong.khcnhtqt@tlu.edu.vn', 'phone' => '024.38533083'],
            ['id' => 35, 'name' => 'ThS. Phạm Văn Đức', 'email' => 'truongphong.tckt@tlu.edu.vn', 'phone' => '024.35634602'],
            ['id' => 36, 'name' => 'Kỹ sư Lê Minh Tuấn', 'email' => 'truongphong.qttb@tlu.edu.vn', 'phone' => '024.35635671'],
            ['id' => 37, 'name' => 'ThS. Vũ Thị Yến', 'email' => 'giamdoc.ttnt@tlu.edu.vn', 'phone' => '024.35643058'],
            ['id' => 38, 'name' => 'TS. Hoàng Văn Quân', 'email' => 'giamdoc.ttth@tlu.edu.vn', 'phone' => '024.35635915'],
            ['id' => 39, 'name' => 'ThS. Nguyễn Thị Bích Ngọc', 'email' => 'giamdoc.tv@tlu.edu.vn', 'phone' => '024.35640068'],
            ['id' => 40, 'name' => 'TS. Trần Văn Hạnh', 'email' => 'truong.tyt@tlu.edu.vn', 'phone' => '024.35632839'],
        ];

        foreach ($departmentUsers as $user) {
            DB::table('users')->insert([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password123'), // Mật khẩu mặc định
                'phone' => $user['phone'],
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('user_has_roles')->insert([
                'user_id' => $user['id'],
                'role_id' => 3
            ]);
        }
    }
}
