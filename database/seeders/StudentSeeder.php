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
        
        // Lấy tất cả các lớp đã có
        $classes = DB::table('classes')->get();
        
        $users = [];
        $students = [];
        $userHasRoles = [];
        
        $userId = DB::table('users')->max('id') + 1; // Bắt đầu từ ID tiếp theo
        $studentId = 1;
        
        // Tạo danh sách mã sinh viên duy nhất (10 chữ số)
        $usedStudentCodes = [];
        
        foreach ($classes as $class) {
            // Mỗi lớp có từ 20-30 sinh viên (trung bình 25)
            $numberOfStudents = rand(1, 2);
            
            // Lấy năm nhập học từ academic_year (ví dụ: "2021-2025" -> 2021)
            $enrollmentYear = (int) substr($class->academic_year, 0, 4);
            
            for ($i = 1; $i <= $numberOfStudents; $i++) {
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $fullName = $lastName . ' ' . $firstName;
                
                // Tạo mã sinh viên 10 chữ số duy nhất
                do {
                    $studentCode = $this->generateUniqueStudentCode($enrollmentYear);
                } while (in_array($studentCode, $usedStudentCodes));
                
                $usedStudentCodes[] = $studentCode;
                $email = $studentCode . '@e.tlu.edu.vn';
                
                // Tạo user
                $users[] = [
                    'id' => $userId,
                    'name' => $fullName,
                    'email' => $email,
                    'email_verified_at' => $faker->boolean(80) ? now() : null,
                    'password' => Hash::make('password123'), // Mật khẩu mặc định
                    'phone' => $faker->phoneNumber,
                    'avatar' => null,
                    'last_login' => $faker->boolean(60) ? $faker->dateTimeBetween('-30 days', 'now') : null,
                    'is_active' => $faker->boolean(90), // 90% sinh viên active
                    'password_reset_token' => null,
                    'password_reset_expiry' => null,
                    'email_verified' => $faker->boolean(80), // 80% đã verify email
                    'verification_token' => null,
                    'verification_token_expiry' => null,
                    'verification_resent_count' => 0,
                    'last_verification_resent_at' => null,
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Tạo student
                $students[] = [
                    'id' => $studentId++,
                    'user_id' => $userId,
                    'class_id' => $class->id,
                    'student_code' => $studentCode,
                    'enrollment_year' => $enrollmentYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Gán role sinh viên (role_id = 1)
                $userHasRoles[] = [
                    'user_id' => $userId,
                    'role_id' => 1,
                ];
                
                $userId++;
            }
        }
        
        // Insert dữ liệu theo batch để tránh vấn đề memory
        echo "Inserting " . count($users) . " users...\n";
        $userChunks = array_chunk($users, 500);
        foreach ($userChunks as $chunk) {
            DB::table('users')->insert($chunk);
        }
        
        echo "Inserting " . count($students) . " students...\n";
        $studentChunks = array_chunk($students, 500);
        foreach ($studentChunks as $chunk) {
            DB::table('students')->insert($chunk);
        }
        
        echo "Inserting " . count($userHasRoles) . " user roles...\n";
        $roleChunks = array_chunk($userHasRoles, 500);
        foreach ($roleChunks as $chunk) {
            DB::table('user_has_roles')->insert($chunk);
        }
        
        echo "Successfully created " . count($students) . " students for " . count($classes) . " classes\n";
    }
    
    /**
     * Tạo mã sinh viên 10 chữ số duy nhất
     */
    private function generateUniqueStudentCode($enrollmentYear)
    {
        // 2 chữ số cuối của năm + 8 chữ số ngẫu nhiên
        $yearSuffix = substr($enrollmentYear, -2);
        $randomNumber = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        
        return $yearSuffix . $randomNumber;
    }
}