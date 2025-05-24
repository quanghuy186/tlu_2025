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
        
        // Danh sách các bộ môn (level 2) - chỉ lấy các đơn vị đào tạo
        $departments = [
            // Bộ môn thuộc Khoa Kinh tế và quản lý
            12, 13, 14, 15, 16, 17, 18, 19,
            // Bộ môn thuộc Khoa Hóa và Môi trường
            20, 21, 22,
            // Bộ môn thuộc Trung tâm Đào tạo quốc tế
            23, 24,
            // Bộ môn thuộc Khoa Kế toán và Kinh doanh
            25, 26, 27, 28,
            // Bộ môn thuộc Khoa Công trình
            41, 42, 43, 44,
            // Bộ môn thuộc Khoa Kỹ thuật tài nguyên nước
            45, 46, 47,
            // Bộ môn thuộc Khoa Cơ khí
            48, 49, 50, 51,
            // Bộ môn thuộc Khoa Điện - Điện tử
            52, 53, 54, 55,
            // Bộ môn thuộc Khoa Công nghệ thông tin
            56, 57, 58, 59,
            // Bộ môn thuộc Khoa Luật và Lý luận chính trị
            60, 61, 62
        ];
        
        $departmentSpecializations = [
            // Khoa Kinh tế và quản lý
            12 => ['Thương mại điện tử', 'Marketing số', 'Kinh doanh trực tuyến'],
            13 => ['Quản trị du lịch', 'Dịch vụ lữ hành', 'Du lịch sinh thái'],
            14 => ['Kinh tế học', 'Kinh tế vĩ mô', 'Kinh tế vi mô'],
            15 => ['Kinh tế xây dựng', 'Quản lý dự án xây dựng', 'Định giá công trình'],
            16 => ['Phát triển kỹ năng mềm', 'Tâm lý học ứng dụng', 'Kỹ năng lãnh đạo'],
            17 => ['Kinh tế số', 'Kinh doanh số', 'Chuyển đổi số'],
            18 => ['Logistics', 'Quản lý chuỗi cung ứng', 'Vận tải đa phương thức'],
            19 => ['Nghiên cứu kinh tế', 'Ứng dụng quản lý', 'Phân tích kinh tế'],
            
            // Khoa Hóa và Môi trường
            20 => ['Kỹ thuật môi trường', 'Quản lý môi trường', 'Xử lý nước thải'],
            21 => ['Kỹ thuật hóa học', 'Công nghệ hóa học', 'Hóa công nghiệp'],
            22 => ['Công nghệ sinh học', 'Sinh học phân tử', 'Công nghệ gen'],
            
            // Trung tâm Đào tạo quốc tế
            23 => ['Ngôn ngữ Anh', 'Văn học Anh', 'Phương pháp giảng dạy tiếng Anh'],
            24 => ['Ngôn ngữ Trung Quốc', 'Văn hóa Trung Quốc', 'Hán ngữ hiện đại'],
            
            // Khoa Kế toán và Kinh doanh
            25 => ['Kế toán tài chính', 'Kế toán quản trị', 'Kế toán thuế'],
            26 => ['Kiểm toán', 'Kiểm toán nội bộ', 'Kiểm toán báo cáo tài chính'],
            27 => ['Tài chính ngân hàng', 'Đầu tư tài chính', 'Quản lý rủi ro'],
            28 => ['Quản trị kinh doanh', 'Chiến lược kinh doanh', 'Marketing'],
            
            // Khoa Công trình
            41 => ['Kỹ thuật xây dựng công trình thủy', 'Thủy lực công trình', 'Thiết kế đập'],
            42 => ['Xây dựng dân dụng', 'Kết cấu công trình', 'Công nghệ xây dựng'],
            43 => ['Xây dựng cầu đường', 'Thiết kế cầu', 'Kỹ thuật giao thông'],
            44 => ['Vật liệu xây dựng', 'Công nghệ bê tông', 'Vật liệu mới'],
            
            // Khoa Kỹ thuật tài nguyên nước
            45 => ['Thủy văn học', 'Dự báo thủy văn', 'Mô hình thủy văn'],
            46 => ['Cấp thoát nước', 'Xử lý nước cấp', 'Mạng lưới cấp thoát nước'],
            47 => ['Kỹ thuật tài nguyên nước', 'Quản lý tài nguyên nước', 'Quy hoạch thủy lợi'],
            
            // Khoa Cơ khí
            48 => ['Kỹ thuật cơ khí', 'Thiết kế máy', 'Cơ học ứng dụng'],
            49 => ['Công nghệ chế tạo máy', 'Gia công cơ khí', 'CAD/CAM'],
            50 => ['Kỹ thuật ô tô', 'Động cơ đốt trong', 'Công nghệ ô tô hiện đại'],
            51 => ['Cơ điện tử', 'Điều khiển tự động', 'Robot công nghiệp'],
            
            // Khoa Điện - Điện tử
            52 => ['Kỹ thuật điện', 'Hệ thống điện', 'Máy điện'],
            53 => ['Điện tử viễn thông', 'Xử lý tín hiệu số', 'Thông tin vô tuyến'],
            54 => ['Tự động hóa', 'Điều khiển quá trình', 'PLC và SCADA'],
            55 => ['Robot và AI', 'Học máy', 'Thị giác máy tính'],
            
            // Khoa Công nghệ thông tin
            56 => ['Công nghệ phần mềm', 'Kiến trúc phần mềm', 'Phát triển ứng dụng'],
            57 => ['Hệ thống thông tin', 'Cơ sở dữ liệu', 'Phân tích hệ thống'],
            58 => ['An toàn thông tin', 'Bảo mật mạng', 'Mã hóa dữ liệu'],
            59 => ['Khoa học máy tính', 'Thuật toán', 'Trí tuệ nhân tạo'],
            
            // Khoa Luật và Lý luận chính trị
            60 => ['Luật hiến pháp', 'Luật hành chính', 'Luật dân sự'],
            61 => ['Luật kinh tế', 'Luật thương mại', 'Luật doanh nghiệp'],
            62 => ['Lý luận chính trị', 'Triết học', 'Kinh tế chính trị']
        ];
        
        $roleId = 2; // Role giảng viên
        $academicRanks = ['ThS', 'ThS', 'ThS', 'TS', 'TS', 'PGS.TS', 'GS.TS']; // Tỷ lệ thực tế
        $positions = ['Giảng viên', 'Giảng viên', 'Giảng viên chính', 'Giảng viên cao cấp'];
        
        // Bắt đầu user_id từ 1000 để tránh trùng với các user đã tạo
        $startUserId = 1000;
        
        for ($i = 1; $i <= 400; $i++) {
            $departmentId = $faker->randomElement($departments);
            $specializations = $departmentSpecializations[$departmentId] ?? ['Chuyên ngành khác'];
            $specialization = $faker->randomElement($specializations);
            
            // Tạo user
            $userId = DB::table('users')->insertGetId([
                'id' => $startUserId + $i,
                'name' => $faker->name,
                'email' => 'gv' . str_pad($i, 4, '0', STR_PAD_LEFT) . '@tlu.edu.vn',
                'phone' => '024' . $faker->numerify('#######'),
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
            
            // Xác định tòa nhà dựa vào khoa
            $building = $this->getBuildingByDepartment($departmentId);
            
            // Tạo teacher
            DB::table('teachers')->insert([
                'user_id' => $userId,
                'department_id' => $departmentId,
                'teacher_code' => 'GV' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'academic_rank' => $faker->randomElement($academicRanks),
                'specialization' => $specialization,
                'position' => $faker->randomElement($positions),
                'office_location' => 'Phòng ' . $faker->numberBetween(101, 509) . ' - ' . $building,
                'office_hours' => $faker->randomElement(['Thứ 2-4', 'Thứ 3-5', 'Thứ 4-6']) . ' (' . $faker->randomElement(['8h-10h', '9h-11h', '14h-16h', '15h-17h']) . ')',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            if ($i % 50 == 0) {
                echo "Đã tạo $i/400 giảng viên...\n";
            }
        }
        
        echo "Hoàn thành! Đã tạo 400 giảng viên.\n";
    }
    
    /**
     * Xác định tòa nhà dựa vào bộ môn
     */
    private function getBuildingByDepartment($departmentId)
    {
        $buildingMap = [
            // Khoa Công trình
            41 => 'Tòa nhà A2', 42 => 'Tòa nhà A2', 43 => 'Tòa nhà A2', 44 => 'Tòa nhà A2',
            // Khoa Kỹ thuật tài nguyên nước
            45 => 'Tòa nhà A3', 46 => 'Tòa nhà A3', 47 => 'Tòa nhà A3',
            // Khoa Cơ khí
            48 => 'Tòa nhà B1', 49 => 'Tòa nhà B1', 50 => 'Tòa nhà B1', 51 => 'Tòa nhà B1',
            // Khoa Điện - Điện tử
            52 => 'Tòa nhà B2', 53 => 'Tòa nhà B2', 54 => 'Tòa nhà B2', 55 => 'Tòa nhà B2',
            // Khoa Kinh tế và quản lý
            12 => 'Tòa nhà A5', 13 => 'Tòa nhà A5', 14 => 'Tòa nhà A5', 15 => 'Tòa nhà A5',
            16 => 'Tòa nhà A5', 17 => 'Tòa nhà A5', 18 => 'Tòa nhà A5', 19 => 'Tòa nhà A5',
            // Khoa Công nghệ thông tin
            56 => 'Tòa nhà C5', 57 => 'Tòa nhà C5', 58 => 'Tòa nhà C5', 59 => 'Tòa nhà C5',
            // Khoa Hóa và Môi trường
            20 => 'Tòa nhà D1', 21 => 'Tòa nhà D1', 22 => 'Tòa nhà D1',
            // Khoa Luật và Lý luận chính trị
            60 => 'Tòa nhà A1', 61 => 'Tòa nhà A1', 62 => 'Tòa nhà A1',
            // Trung tâm Đào tạo quốc tế
            23 => 'Tòa nhà A6', 24 => 'Tòa nhà A6',
            // Khoa Kế toán và Kinh doanh
            25 => 'Tòa nhà A7', 26 => 'Tòa nhà A7', 27 => 'Tòa nhà A7', 28 => 'Tòa nhà A7',
        ];
        
        return $buildingMap[$departmentId] ?? 'Tòa nhà A1';
    }
}