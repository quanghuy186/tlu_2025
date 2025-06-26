<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');
        
        $classes = DB::table('classes')->get();
        
        $users = [];
        $students = [];
        $userHasRoles = [];
        
        // Bắt đầu từ user_id = 1500 (sau teachers)
        $userId = 1500;
        $studentId = 1;
        
        // Tạo danh sách mã sinh viên duy nhất
        $usedStudentCodes = [];
        
        $lastNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý'];
        $maleFirstNames = ['Anh', 'Bảo', 'Cường', 'Dũng', 'Đức', 'Hải', 'Hoàng', 'Hùng', 'Khang', 'Long', 'Minh', 'Nam', 'Phúc', 'Quang', 'Sơn', 'Thành', 'Tuấn', 'Việt'];
        $femaleFirstNames = ['An', 'Anh', 'Chi', 'Dung', 'Giang', 'Hà', 'Hạnh', 'Hương', 'Lan', 'Linh', 'Mai', 'My', 'Nga', 'Phương', 'Thảo', 'Thu', 'Trang', 'Vy'];
        $middleNames = ['Văn', 'Thị', 'Đức', 'Minh', 'Hoàng', 'Thanh', 'Thành', 'Quốc', 'Xuân', 'Thu', 'Hữu', 'Công', 'Bảo', 'Ngọc'];
        
        $totalStudents = 0;
        
        foreach ($classes as $class) {
            // Số lượng sinh viên theo loại lớp và năm học
            $numberOfStudents = $this->getStudentCountByClass($class);
            
            // Lấy năm nhập học từ academic_year (ví dụ: "2021-2025" -> 2021)
            $enrollmentYear = (int) substr($class->academic_year, 0, 4);
            
            // Lấy mã khóa từ class_code (ví dụ: "63IT01" -> 63)
            $courseCode = substr($class->class_code, 0, 2);
            
            for ($i = 1; $i <= $numberOfStudents; $i++) {
                // Random giới tính
                $isMale = $faker->boolean(55); // 55% nam
                
                // Tạo tên Việt Nam
                $lastName = $faker->randomElement($lastNames);
                $middleName = $isMale ? $faker->randomElement(['Văn', 'Đức', 'Minh', 'Quốc', 'Hoàng', 'Thanh', 'Hữu', 'Công']) 
                                      : $faker->randomElement(['Thị', 'Thu', 'Ngọc', 'Minh', 'Hoàng', 'Thanh', 'Bảo']);
                $firstName = $isMale ? $faker->randomElement($maleFirstNames) : $faker->randomElement($femaleFirstNames);
                
                $fullName = $lastName . ' ' . $middleName . ' ' . $firstName;
                
                // Tạo mã sinh viên duy nhất theo khóa và ngành
                do {
                    $studentCode = $this->generateStudentCode($courseCode, $class->department_id, count($usedStudentCodes) + 1);
                } while (in_array($studentCode, $usedStudentCodes));
                
                $usedStudentCodes[] = $studentCode;
                $email = strtolower($studentCode) . '@e.tlu.edu.vn';
                
                // Tạo số điện thoại Việt Nam hợp lệ
                $phonePrefix = $faker->randomElement(['03', '05', '07', '08', '09']);
                $phone = $phonePrefix . $faker->numerify('#######');
                
                // Tạo user
                $users[] = [
                    'id' => $userId,
                    'name' => $fullName,
                    'email' => $email,
                    'email_verified_at' => $faker->boolean(85) ? now() : null,
                    'password' => Hash::make('password123'),
                    'phone' => $phone,
                    'avatar' => null,
                    'last_login' => $faker->boolean(70) ? $faker->dateTimeBetween('-7 days', 'now') : null,
                    'is_active' => $this->getActiveStatus($enrollmentYear),
                    'password_reset_token' => null,
                    'password_reset_expiry' => null,
                    'email_verified' => $faker->boolean(85),
                    'verification_token' => null,
                    'verification_token_expiry' => null,
                    'verification_resent_count' => 0,
                    'last_verification_resent_at' => null,
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $students[] = [
                    'id' => $studentId++,
                    'user_id' => $userId,
                    'class_id' => $class->id,
                    'student_code' => $studentCode,
                    'enrollment_year' => $enrollmentYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $userHasRoles[] = [
                    'user_id' => $userId,
                    'role_id' => 1,
                ];
                
                $userId++;
                $totalStudents++;
            }
            
            if ($totalStudents % 100 == 0) {
                echo "Đã tạo $totalStudents sinh viên...\n";
            }
        }
        
        echo "\nBắt đầu insert dữ liệu...\n";
        
        echo "Inserting " . count($users) . " users...\n";
        $userChunks = array_chunk($users, 500);
        foreach ($userChunks as $index => $chunk) {
            DB::table('users')->insert($chunk);
            echo "  Batch " . ($index + 1) . "/" . count($userChunks) . " completed\n";
        }
        
        echo "Inserting " . count($students) . " students...\n";
        $studentChunks = array_chunk($students, 500);
        foreach ($studentChunks as $index => $chunk) {
            DB::table('students')->insert($chunk);
            echo "  Batch " . ($index + 1) . "/" . count($studentChunks) . " completed\n";
        }
        
        echo "Inserting " . count($userHasRoles) . " user roles...\n";
        $roleChunks = array_chunk($userHasRoles, 500);
        foreach ($roleChunks as $index => $chunk) {
            DB::table('user_has_roles')->insert($chunk);
            echo "  Batch " . ($index + 1) . "/" . count($roleChunks) . " completed\n";
        }
        
        echo "\nSuccessfully created " . count($students) . " students for " . count($classes) . " classes\n";
        echo "Trung bình: " . round(count($students) / count($classes), 1) . " sinh viên/lớp\n";
    }
 
    private function getStudentCountByClass($class)
    {
        $classCode = $class->class_code;
        
        // Các ngành hot có nhiều sinh viên hơn
        $popularMajors = ['IT', 'BA', 'CIVENG', 'ELECENG', 'ACC', 'FINBAN', 'SE', 'ECOM'];
        $mediumMajors = ['MECHENG', 'ENVENG', 'LAW', 'HYDROENG', 'WATRENG', 'AUTOENG'];
        
        foreach ($popularMajors as $major) {
            if (strpos($classCode, $major) !== false) {
                return rand(35, 45); // 35-45 sinh viên
            }
        }
        
        foreach ($mediumMajors as $major) {
            if (strpos($classCode, $major) !== false) {
                return rand(25, 35); // 25-35 sinh viên
            }
        }
        
        // Các ngành khác
        return rand(20, 30); // 20-30 sinh viên
    }
    
    private function generateStudentCode($courseCode, $departmentId, $sequence)
    {
        $majorCodes = [
            // Mapping department_id to major code
            41 => 'HY', 42 => 'CE', 43 => 'TE', 44 => 'CM',
            45 => 'HY', 46 => 'WS', 47 => 'WR',
            48 => 'ME', 49 => 'MT', 50 => 'AU', 51 => 'MC',
            52 => 'EE', 53 => 'ET', 54 => 'AT', 55 => 'RB',
            56 => 'SE', 57 => 'IS', 58 => 'IS', 59 => 'IT',
            12 => 'EC', 13 => 'TM', 14 => 'EN', 15 => 'CE',
            17 => 'DE', 18 => 'LG', 20 => 'EV', 21 => 'CH',
            22 => 'BT', 23 => 'EL', 24 => 'CN', 25 => 'AC',
            26 => 'AU', 27 => 'FN', 28 => 'BA', 60 => 'LW', 61 => 'EL'
        ];
        
        $majorCode = $majorCodes[$departmentId] ?? 'GE';
        $sequenceNumber = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        
        return $courseCode . $majorCode . $sequenceNumber;
    }
    
    private function getActiveStatus($enrollmentYear)
    {
        $currentYear = 2024;
        $yearsStudied = $currentYear - $enrollmentYear;
        
        // Sinh viên năm 4 có 95% active (một số đã tốt nghiệp sớm)
        if ($yearsStudied >= 4) return rand(1, 100) <= 95;
        
        // Sinh viên các năm khác 98% active
        return rand(1, 100) <= 98;
    }
}