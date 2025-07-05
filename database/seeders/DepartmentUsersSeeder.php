<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentUsersSeeder extends Seeder
{
   
    public function run()
    {
        $departmentUsers = [
            ['id' => 1, 'name' => 'PGS.TS Nguyễn Văn Minh', 'email' => 'hieutruong@tlu.edu.vn', 'phone' => '024.38522201'],
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
            
            ['id' => 41, 'name' => 'PGS.TS Nguyễn Văn Thắng', 'email' => 'truongbm.ktxdctt@tlu.edu.vn', 'phone' => '024.38522211'],
            ['id' => 42, 'name' => 'TS. Lê Thị Thu Hương', 'email' => 'truongbm.xddvcn@tlu.edu.vn', 'phone' => '024.38522212'],
            ['id' => 43, 'name' => 'TS. Phạm Văn Dũng', 'email' => 'truongbm.xdcd@tlu.edu.vn', 'phone' => '024.38522213'],
            ['id' => 44, 'name' => 'ThS. Trần Minh Tuấn', 'email' => 'truongbm.vlxd@tlu.edu.vn', 'phone' => '024.38522214'],
            
            ['id' => 45, 'name' => 'PGS.TS Hoàng Văn Hùng', 'email' => 'truongbm.tv@tlu.edu.vn', 'phone' => '024.38522216'],
            ['id' => 46, 'name' => 'TS. Nguyễn Thị Lan Phương', 'email' => 'truongbm.ctn@tlu.edu.vn', 'phone' => '024.38522217'],
            ['id' => 47, 'name' => 'TS. Vũ Văn Thành', 'email' => 'truongbm.kttn@tlu.edu.vn', 'phone' => '024.38522218'],
            
            ['id' => 48, 'name' => 'PGS.TS Lê Văn Cường', 'email' => 'truongbm.ktck@tlu.edu.vn', 'phone' => '024.38522221'],
            ['id' => 49, 'name' => 'TS. Nguyễn Minh Hải', 'email' => 'truongbm.cnctm@tlu.edu.vn', 'phone' => '024.38522222'],
            ['id' => 50, 'name' => 'TS. Phạm Văn Nam', 'email' => 'truongbm.ktot@tlu.edu.vn', 'phone' => '024.38522223'],
            ['id' => 51, 'name' => 'TS. Trần Thị Thanh', 'email' => 'truongbm.cdt@tlu.edu.vn', 'phone' => '024.38522224'],
            
            ['id' => 52, 'name' => 'PGS.TS Nguyễn Văn Đông', 'email' => 'truongbm.ktd@tlu.edu.vn', 'phone' => '024.38522226'],
            ['id' => 53, 'name' => 'TS. Lê Minh Hùng', 'email' => 'truongbm.dtvt@tlu.edu.vn', 'phone' => '024.38522227'],
            ['id' => 54, 'name' => 'TS. Hoàng Văn Phong', 'email' => 'truongbm.ktdktdh@tlu.edu.vn', 'phone' => '024.38522228'],
            ['id' => 55, 'name' => 'TS. Vũ Thị Kim Chi', 'email' => 'truongbm.rttnt@tlu.edu.vn', 'phone' => '024.38522229'],
            
            ['id' => 56, 'name' => 'PGS.TS Trần Văn Long', 'email' => 'truongbm.cnpm@tlu.edu.vn', 'phone' => '024.38522236'],
            ['id' => 57, 'name' => 'TS. Nguyễn Thị Thu Hà', 'email' => 'truongbm.httt@tlu.edu.vn', 'phone' => '024.38522237'],
            ['id' => 58, 'name' => 'TS. Lê Văn Hoàng', 'email' => 'truongbm.attt@tlu.edu.vn', 'phone' => '024.38522238'],
            ['id' => 59, 'name' => 'TS. Phạm Minh Tuấn', 'email' => 'truongbm.khmt@tlu.edu.vn', 'phone' => '024.38522239'],
            
            ['id' => 60, 'name' => 'PGS.TS Nguyễn Văn Luật', 'email' => 'truongbm.l@tlu.edu.vn', 'phone' => '024.38522246'],
            ['id' => 61, 'name' => 'TS. Trần Thị Hồng Nhung', 'email' => 'truongbm.lkt@tlu.edu.vn', 'phone' => '024.38522247'],
            ['id' => 62, 'name' => 'TS. Vũ Văn Chính', 'email' => 'truongbm.llct@tlu.edu.vn', 'phone' => '024.38522248'],
        ];

        foreach ($departmentUsers as $user) {
            DB::table('users')->insert([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password123'), 
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