<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy danh sách các department_id từ database
        $departments = DB::table('departments')->where('level', '>=', 2)->pluck('id')->toArray();
        
        // Định nghĩa các học hàm học vị
        $academicRanks = [
            'Giáo sư',
            'Phó Giáo sư', 
            'Tiến sĩ',
            'Thạc sĩ',
            'Kỹ sư',
            'Cử nhân'
        ];
        
        // Định nghĩa các chuyên ngành theo khoa
        $specializations = [
            // CNTT
            'Công nghệ phần mềm',
            'Hệ thống thông tin',
            'Khoa học máy tính',
            'An toàn thông tin',
            'Trí tuệ nhân tạo',
            'Khoa học dữ liệu',
            'Công nghệ web',
            'Phát triển ứng dụng di động',
            'Điện toán đám mây',
            'IoT và Embedded Systems',
            
            // Điện - Điện tử
            'Kỹ thuật điện',
            'Tự động hóa',
            'Điện tử viễn thông',
            'Kỹ thuật điều khiển',
            'Năng lượng tái tạo',
            'Điện tử công suất',
            'Xử lý tín hiệu số',
            'Mạng thông minh',
            'Robotics',
            'Hệ thống nhúng',
            
            // Kinh tế & Quản lý
            'Quản trị kinh doanh',
            'Tài chính ngân hàng',
            'Marketing',
            'Kinh tế phát triển',
            'Quản lý dự án',
            'Logistics',
            'E-commerce',
            'Quản trị nhân lực',
            'Kế toán',
            'Kiểm toán',
            
            // Xây dựng
            'Kết cấu công trình',
            'Địa kỹ thuật',
            'Vật liệu xây dựng',
            'Quản lý xây dựng',
            'Kiến trúc',
            'Quy hoạch đô thị',
            'Kỹ thuật giao thông',
            'Cầu đường',
            'Công trình ngầm',
            'BIM và CAD',
            
            // Thủy lợi
            'Thủy lực',
            'Công trình thủy',
            'Thủy văn',
            'Môi trường nước',
            'Quản lý tài nguyên nước',
            'Thủy điện',
            'Tưới tiêu',
            'Phòng chống thiên tai',
            'Hải dương học',
            'Khí tượng thủy văn'
        ];
        
        // Định nghĩa các chức vụ
        $positions = [
            'Giảng viên',
            'Giảng viên chính',
            'Phó trưởng bộ môn',
            'Thư ký khoa',
            'Chuyên viên',
            'Trợ lý giảng dạy',
            'Nghiên cứu viên',
            'Giảng viên kiêm nhiệm'
        ];
        
        // Tên họ Việt Nam phổ biến
        $firstNames = [
            'Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng',
            'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý', 'Đinh', 'Lương', 'Tạ', 'Mai'
        ];
        
        $middleNames = [
            'Văn', 'Thị', 'Đức', 'Minh', 'Anh', 'Thu', 'Hồng', 'Quang', 'Hải', 'Tuấn',
            'Hoài', 'Thanh', 'Bảo', 'Kim', 'Xuân', 'An', 'Phương', 'Lan', 'Mai', 'Hương'
        ];
        
        $lastNames = [
            'Anh', 'Bình', 'Cường', 'Dũng', 'Đạt', 'Giang', 'Hùng', 'Khoa', 'Long', 'Minh',
            'Nam', 'Phúc', 'Quân', 'Sơn', 'Tâm', 'Vũ', 'Yến', 'Linh', 'Nga', 'Thảo',
            'Trang', 'Hà', 'Hương', 'Lan', 'Mai', 'Nhung', 'Oanh', 'Phương', 'Thu', 'Trang'
        ];
        
        // Địa điểm văn phòng
        $officeLocations = [
            'Tòa A, phòng A101', 'Tòa A, phòng A102', 'Tòa A, phòng A103', 'Tòa A, phòng A201', 'Tòa A, phòng A202',
            'Tòa B, phòng B101', 'Tòa B, phòng B102', 'Tòa B, phòng B201', 'Tòa B, phòng B202', 'Tòa B, phòng B301',
            'Tòa C, phòng C101', 'Tòa C, phòng C102', 'Tòa C, phòng C201', 'Tòa C, phòng C202', 'Tòa C, phòng C301',
            'Tòa D, phòng D101', 'Tòa D, phòng D102', 'Tòa D, phòng D201', 'Tòa D, phòng D301', 'Tòa D, phòng D401',
            'Tòa E, phòng E101', 'Tòa E, phòng E201', 'Tòa E, phòng E301', 'Tòa F, phòng F101', 'Tòa F, phòng F201'
        ];
        
        // Mảng lưu user_id của các giảng viên để gán role
        $teacherUserIds = [];
        
        // Tạo 300 giảng viên
        for ($i = 1; $i <= 300; $i++) {
            // Tạo tên ngẫu nhiên
            $firstName = $faker->randomElement($firstNames);
            $middleName = $faker->randomElement($middleNames);
            $lastName = $faker->randomElement($lastNames);
            $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
            
            // Tạo email từ tên
            $emailName = $this->removeVietnameseAccents(strtolower($firstName . $middleName . $lastName));
            $email = $emailName . $i . '@tlu.edu.vn';
            
            // Tạo user trước
            $userId = DB::table('users')->insertGetId([
                'name' => $fullName,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => $faker->numerify('0##########'),
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Lưu user_id để gán role sau
            $teacherUserIds[] = $userId;
            
            // Tạo mã giảng viên
            $teacherCode = 'GV' . str_pad($i, 4, '0', STR_PAD_LEFT);
            
            // Tạo giờ làm việc ngẫu nhiên
            $officeHours = $this->generateOfficeHours($faker);
            
            // Tạo teacher
            DB::table('teachers')->insert([
                'department_id' => $faker->randomElement($departments),
                'user_id' => $userId,
                'teacher_code' => $teacherCode,
                'academic_rank' => $faker->randomElement($academicRanks),
                'specialization' => $faker->randomElement($specializations),
                'position' => $faker->randomElement($positions),
                'office_location' => $faker->randomElement($officeLocations),
                'office_hours' => $officeHours,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Gán role_id = 2 cho tất cả giảng viên
        foreach ($teacherUserIds as $userId) {
            DB::table('user_has_roles')->insert([
                'user_id' => $userId,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Loại bỏ dấu tiếng Việt
     */
    private function removeVietnameseAccents($str)
    {
        $accents = [
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ',
            'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
            'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
            'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
            'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
            'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
            'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
            'Đ'
        ];
        
        $noAccents = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd',
            'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
            'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I', 'I',
            'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y', 'Y', 'Y', 'Y',
            'D'
        ];
        
        return str_replace($accents, $noAccents, $str);
    }
    
    /**
     * Tạo giờ làm việc ngẫu nhiên
     */
    private function generateOfficeHours($faker)
    {
        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6'];
        $selectedDays = $faker->randomElements($days, $faker->numberBetween(2, 5));
        
        $hours = [];
        foreach ($selectedDays as $day) {
            $startHour = $faker->numberBetween(7, 14);
            $endHour = $startHour + $faker->numberBetween(2, 4);
            $hours[] = $day . ': ' . sprintf('%02d:00 - %02d:00', $startHour, $endHour);
        }
        
        return implode(', ', $hours);
    }
}
