<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');
        
        $departments = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28];
        
        $departmentSpecializations = [
            2 => ['Kỹ thuật xây dựng dân dụng', 'Kỹ thuật cầu đường', 'Kỹ thuật thủy lợi'],
            3 => ['Kỹ thuật tài nguyên nước', 'Thủy văn học', 'Cấp thoát nước'],
            4 => ['Kỹ thuật cơ khí', 'Chế tạo máy', 'Kỹ thuật ô tô'],
            5 => ['Kỹ thuật điện', 'Điện tử viễn thông', 'Tự động hóa'],
            6 => ['Kinh tế học', 'Quản trị kinh doanh', 'Kinh tế đầu tư'],
            7 => ['Công nghệ thông tin', 'An ninh mạng', 'Trí tuệ nhân tạo'],
            8 => ['Kỹ thuật môi trường', 'Hóa học', 'Công nghệ sinh học'],
            9 => ['Luật kinh tế', 'Luật dân sự', 'Lý luận chính trị'],
            10 => ['Quan hệ quốc tế', 'Ngôn ngữ học', 'Văn hóa học'],
            11 => ['Kế toán', 'Kiểm toán', 'Tài chính ngân hàng'],
            12 => ['Thương mại điện tử', 'Marketing số'],
            13 => ['Quản trị du lịch', 'Dịch vụ lữ hành'],
            14 => ['Kinh tế học', 'Kinh tế vĩ mô'],
            15 => ['Kinh tế xây dựng', 'Quản lý dự án xây dựng'],
            16 => ['Phát triển kỹ năng mềm', 'Tâm lý học'],
            17 => ['Kinh tế số', 'Kinh doanh số'],
            18 => ['Logistics', 'Quản lý chuỗi cung ứng'],
            19 => ['Nghiên cứu kinh tế', 'Ứng dụng quản lý'],
            20 => ['Kỹ thuật môi trường', 'Quản lý môi trường'],
            21 => ['Kỹ thuật hóa học', 'Công nghệ hóa học'],
            22 => ['Công nghệ sinh học', 'Sinh học phân tử'],
            23 => ['Ngôn ngữ Anh', 'Văn học Anh'],
            24 => ['Ngôn ngữ Trung Quốc', 'Văn hóa Trung Quốc'],
            25 => ['Kế toán', 'Kế toán quản trị'],
            26 => ['Kiểm toán', 'Kiểm toán nội bộ'],
            27 => ['Tài chính ngân hàng', 'Đầu tư tài chính'],
            28 => ['Quản trị kinh doanh', 'Chiến lược kinh doanh']
        ];
        
        $roleId = 2;
        $academicRanks = ['TS', 'ThS', 'PGS', 'GS'];
        $positions = ['Giảng viên', 'Giảng viên chính'];
        
        for ($i = 1; $i <= 400; $i++) {
            $departmentId = $faker->randomElement($departments);
            $specializations = $departmentSpecializations[$departmentId] ?? ['Chuyên ngành khác'];
            $specialization = $faker->randomElement($specializations);
            
            // Tạo user (bỏ created_at, updated_at để Laravel tự động xử lý)
            $userId = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber(),
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Gán role
            DB::table('user_has_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
            ]);
            
            // Tạo teacher
            DB::table('teachers')->insert([
                'user_id' => $userId,
                'department_id' => $departmentId,
                'teacher_code' => 'GV' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'academic_rank' => $faker->randomElement($academicRanks),
                'specialization' => $specialization,
                'position' => $faker->randomElement($positions),
                'office_location' => 'Phòng ' . $faker->numberBetween(101, 509) . ' - Tòa ' . $faker->randomElement(['A1', 'A2', 'A3', 'B1', 'B2', 'C1', 'C2']),
                'office_hours' => $faker->randomElement(['Thứ 2-4', 'Thứ 3-5', 'Thứ 4-6']) . ' (' . $faker->randomElement(['8h-10h', '9h-11h', '14h-16h']) . ')'
            ]);
            
            if ($i % 50 == 0) {
                echo "Đã tạo $i/400 giảng viên...\n";
            }
        }
        
        echo "Hoàn thành! Đã tạo 400 giảng viên.\n";
    }
}