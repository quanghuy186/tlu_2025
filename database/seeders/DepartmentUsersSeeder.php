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
            
            // Level 3 - Người phụ trách các ngành học
            ['id' => 41, 'name' => 'TS. Nguyễn Minh Hoàng', 'email' => 'phutrach.xdctthuy@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 42, 'name' => 'TS. Lê Văn Cường', 'email' => 'phutrach.ktxd@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 43, 'name' => 'ThS. Phạm Đức Minh', 'email' => 'phutrach.cnktxd@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 44, 'name' => 'TS. Vũ Thành Đạt', 'email' => 'phutrach.ktxdctgt@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 45, 'name' => 'ThS. Hoàng Minh Thắng', 'email' => 'phutrach.qlxd@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 46, 'name' => 'TS. Đỗ Văn Tín', 'email' => 'phutrach.kttnr@tlu.edu.vn', 'phone' => '024.38522215'],
            ['id' => 47, 'name' => 'ThS. Nguyễn Thị Bình', 'email' => 'phutrach.ktctn@tlu.edu.vn', 'phone' => '024.38522215'],
            ['id' => 48, 'name' => 'TS. Lê Quang Minh', 'email' => 'phutrach.ktcsht@tlu.edu.vn', 'phone' => '024.38522215'],
            ['id' => 49, 'name' => 'ThS. Trần Thị Ngọc', 'email' => 'phutrach.thuyvanhoc@tlu.edu.vn', 'phone' => '024.38522215'],
            ['id' => 50, 'name' => 'TS. Phan Văn Dũng', 'email' => 'phutrach.ktck@tlu.edu.vn', 'phone' => '024.38522220'],
            ['id' => 51, 'name' => 'ThS. Nguyễn Thanh Sơn', 'email' => 'phutrach.cnctm@tlu.edu.vn', 'phone' => '024.38522220'],
            ['id' => 52, 'name' => 'TS. Lê Minh Đức', 'email' => 'phutrach.ktoto@tlu.edu.vn', 'phone' => '024.38522220'],
            ['id' => 53, 'name' => 'ThS. Vũ Thanh Bình', 'email' => 'phutrach.ktcdt@tlu.edu.vn', 'phone' => '024.38522220'],
            ['id' => 54, 'name' => 'TS. Đặng Văn Hùng', 'email' => 'phutrach.ktdien@tlu.edu.vn', 'phone' => '024.38522225'],
            ['id' => 55, 'name' => 'ThS. Nguyễn Minh Tuấn', 'email' => 'phutrach.ktdktdh@tlu.edu.vn', 'phone' => '024.38522225'],
            ['id' => 56, 'name' => 'TS. Trần Thành Nam', 'email' => 'phutrach.ktdtvt@tlu.edu.vn', 'phone' => '024.38522225'],
            ['id' => 57, 'name' => 'ThS. Lê Văn Thành', 'email' => 'phutrach.ktrobotdktm@tlu.edu.vn', 'phone' => '024.38522225'],
            ['id' => 58, 'name' => 'TS. Hoàng Minh Hải', 'email' => 'phutrach.cntt@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 59, 'name' => 'ThS. Nguyễn Văn Tâm', 'email' => 'phutrach.httt@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 60, 'name' => 'TS. Phạm Quang Dũng', 'email' => 'phutrach.ktpm@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 61, 'name' => 'ThS. Lê Thị Mai Linh', 'email' => 'phutrach.ttnt_khdl@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 62, 'name' => 'TS. Vũ Đức Thành', 'email' => 'phutrach.anm@tlu.edu.vn', 'phone' => '024.38522235'],
            ['id' => 63, 'name' => 'ThS. Đỗ Thị Hồng Nhung', 'email' => 'phutrach.kinhte@tlu.edu.vn', 'phone' => '024.38522233'],
            ['id' => 64, 'name' => 'TS. Nguyễn Văn Lâm', 'email' => 'phutrach.ktxd_major@tlu.edu.vn', 'phone' => '024.38522234'],
            ['id' => 65, 'name' => 'ThS. Trần Thị Phương Linh', 'email' => 'phutrach.logistics@tlu.edu.vn', 'phone' => '024.38522237'],
            ['id' => 66, 'name' => 'TS. Lê Văn Hoàng', 'email' => 'phutrach.tmdt@tlu.edu.vn', 'phone' => '024.38522231'],
            ['id' => 67, 'name' => 'ThS. Phạm Thị Thu Hà', 'email' => 'phutrach.kinhteaso@tlu.edu.vn', 'phone' => '024.38522236'],
            ['id' => 68, 'name' => 'TS. Hoàng Văn Kiên', 'email' => 'phutrach.tcnh@tlu.edu.vn', 'phone' => '024.38522258'],
            ['id' => 69, 'name' => 'ThS. Nguyễn Thị Lan Anh', 'email' => 'phutrach.fintech@tlu.edu.vn', 'phone' => '024.38522258'],
            ['id' => 70, 'name' => 'TS. Vũ Minh Sơn', 'email' => 'phutrach.kiemtoan@tlu.edu.vn', 'phone' => '024.38522257'],
            ['id' => 71, 'name' => 'ThS. Lê Thị Thanh Hương', 'email' => 'phutrach.qtkd@tlu.edu.vn', 'phone' => '024.38522259'],
            ['id' => 72, 'name' => 'TS. Đặng Văn Long', 'email' => 'phutrach.ketoan@tlu.edu.vn', 'phone' => '024.38522256'],
            ['id' => 73, 'name' => 'ThS. Trần Thị Minh Hạnh', 'email' => 'phutrach.ketoan_acca@tlu.edu.vn', 'phone' => '024.38522256'],
            ['id' => 74, 'name' => 'TS. Nguyễn Thị Hồng Vân', 'email' => 'phutrach.dulich@tlu.edu.vn', 'phone' => '024.38522232'],
            ['id' => 75, 'name' => 'ThS. Lê Văn Tuấn', 'email' => 'phutrach.ktmt@tlu.edu.vn', 'phone' => '024.38522241'],
            ['id' => 76, 'name' => 'TS. Phạm Thị Thu Trang', 'email' => 'phutrach.cnsh@tlu.edu.vn', 'phone' => '024.38522243'],
            ['id' => 77, 'name' => 'ThS. Hoàng Văn Dương', 'email' => 'phutrach.kthh@tlu.edu.vn', 'phone' => '024.38522242'],
            ['id' => 78, 'name' => 'TS. Vũ Thị Minh Hoa', 'email' => 'phutrach.luat@tlu.edu.vn', 'phone' => '024.38522245'],
            ['id' => 79, 'name' => 'ThS. Nguyễn Văn Hùng', 'email' => 'phutrach.luatkt@tlu.edu.vn', 'phone' => '024.38522245'],
            ['id' => 80, 'name' => 'TS. Lý Minh Khang', 'email' => 'phutrach.chinese@tlu.edu.vn', 'phone' => '024.38522252'],
            ['id' => 81, 'name' => 'ThS. Đỗ Thị Hương Lan', 'email' => 'phutrach.english@tlu.edu.vn', 'phone' => '024.38522251'],
            ['id' => 82, 'name' => 'TS. Trần Minh Quân', 'email' => 'phutrach.ktxd_tientien@tlu.edu.vn', 'phone' => '024.38522210'],
            ['id' => 83, 'name' => 'ThS. Lê Thị Bích Ngọc', 'email' => 'phutrach.kttnr_tientien@tlu.edu.vn', 'phone' => '024.38522215']
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
