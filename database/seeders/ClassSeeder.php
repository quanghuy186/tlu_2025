<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Các khóa học (năm bắt đầu)
        $khoaHoc = [61, 62, 63, 64, 65];
        
        // Tên ngành học
        $nganh = [
            'Công nghệ thông tin',
            'Kỹ thuật phần mềm',
            'An toàn thông tin',
            'Khoa học máy tính',
            'Hệ thống thông tin',
            'Mạng máy tính và truyền thông',
            'Kỹ thuật điện tử',
            'Quản trị kinh doanh',
            'Kế toán',
            'Marketing'
        ];
        
        // Số thứ tự lớp
        $soThuTu = [1, 2, 3, 4, 5, 6];
        
        // Học kỳ tiếng Việt
        $semesters = ['Học kỳ 1', 'Học kỳ 2', 'Học kỳ hè'];
        
        // Năm học
        $academicYears = ['2023-2024', '2024-2025'];
        
        // Department IDs (thay đổi theo hệ thống của bạn)
        $departmentIds = [1, 2, 3, 4, 5]; // Giả sử có 5 khoa
        
        $classes = [];
        
        // Tạo 20 bản ghi
        for ($i = 0; $i < 20; $i++) {
            $khoaRandom = $khoaHoc[array_rand($khoaHoc)];
            $nganhRandom = $nganh[array_rand($nganh)];
            $soThuTuRandom = $soThuTu[array_rand($soThuTu)];
            
            // Tạo tên lớp theo định dạng "63 Công nghệ thông tin 4"
            $className = $khoaRandom . ' ' . $nganhRandom . ' ' . $soThuTuRandom;
            
            // Tạo mã lớp từ tên lớp
            // Ví dụ: "63CNTT4" từ "63 Công nghệ thông tin 4"
            $classCode = $khoaRandom;
            
            // Lấy chữ cái đầu của mỗi từ trong tên ngành
            $words = explode(' ', $nganhRandom);
            foreach ($words as $word) {
                $classCode .= mb_substr($word, 0, 1, 'UTF-8');
            }
            
            $classCode .= $soThuTuRandom;
            $classCode = strtoupper($classCode);
            
            $classes[] = [
                'class_code' => $classCode,
                'class_name' => $className,
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'academic_year' => $academicYears[array_rand($academicYears)],
                'semester' => $semesters[array_rand($semesters)],
                'teacher_id' => null, // Để null theo yêu cầu
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('classes')->insert($classes);
    }
}
