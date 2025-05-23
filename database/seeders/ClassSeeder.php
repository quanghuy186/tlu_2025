<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClassSeeder extends Seeder
{
     public function run()
    {
        // Danh sách các ngành từ department data với mã viết tắt tiếng Anh
        $majors = [
            // Khoa Công trình
            ['name' => 'Kỹ thuật xây dựng công trình thủy', 'code' => 'HYDROENG', 'department_id' => 2],
            ['name' => 'Kỹ thuật xây dựng', 'code' => 'CIVENG', 'department_id' => 2],
            ['name' => 'Công nghệ kỹ thuật xây dựng', 'code' => 'CONTECH', 'department_id' => 2],
            ['name' => 'Kỹ thuật xây dựng công trình giao thông', 'code' => 'TRAENG', 'department_id' => 2],
            ['name' => 'Quản lí xây dựng', 'code' => 'CONMGT', 'department_id' => 2],
            
            // Khoa Kỹ thuật tài nguyên nước
            ['name' => 'Kỹ thuật tài nguyên nước', 'code' => 'WATRENG', 'department_id' => 3],
            ['name' => 'Kỹ thuật cấp thoát nước', 'code' => 'WASUENG', 'department_id' => 3],
            ['name' => 'Kỹ thuật cơ sở hạ tầng', 'code' => 'INFENG', 'department_id' => 3],
            ['name' => 'Thủy văn học', 'code' => 'HYDRO', 'department_id' => 3],
            
            // Khoa Cơ khí
            ['name' => 'Kỹ thuật cơ khí', 'code' => 'MECHENG', 'department_id' => 4],
            ['name' => 'Công nghệ chế tạo máy', 'code' => 'MANTECH', 'department_id' => 4],
            ['name' => 'Kỹ thuật ô tô', 'code' => 'AUTOENG', 'department_id' => 4],
            ['name' => 'Kỹ thuật cơ điện tử', 'code' => 'MECHAENG', 'department_id' => 4],
            
            // Khoa Điện - Điện tử
            ['name' => 'Kỹ thuật điện', 'code' => 'ELECENG', 'department_id' => 5],
            ['name' => 'Kỹ thuật điều khiển và tự động hóa', 'code' => 'AUTENG', 'department_id' => 5],
            ['name' => 'Kỹ thuật điện tử - viễn thông', 'code' => 'TELEENG', 'department_id' => 5],
            ['name' => 'Kỹ thuật Robot và Điều khiển thông minh', 'code' => 'ROBENG', 'department_id' => 5],
            
            // Khoa Công nghệ thông tin
            ['name' => 'Công nghệ thông tin', 'code' => 'IT', 'department_id' => 7],
            ['name' => 'Hệ thống thông tin', 'code' => 'IS', 'department_id' => 7],
            ['name' => 'Kỹ thuật phần mềm', 'code' => 'SE', 'department_id' => 7],
            ['name' => 'Trí tuệ nhân tạo và khoa học dữ liệu', 'code' => 'AIDT', 'department_id' => 7],
            ['name' => 'An toàn thông tin', 'code' => 'ISEC', 'department_id' => 7],
            
            // Khoa Kinh tế và quản lý
            ['name' => 'Kinh tế', 'code' => 'ECON', 'department_id' => 6],
            ['name' => 'Kinh tế xây dựng', 'code' => 'CONECON', 'department_id' => 6],
            ['name' => 'Logistics và quản lí chuỗi cung ứng', 'code' => 'LSCM', 'department_id' => 6],
            ['name' => 'Thương mại điện tử', 'code' => 'ECOM', 'department_id' => 6],
            ['name' => 'Kinh tế số', 'code' => 'DIECON', 'department_id' => 6],
            ['name' => 'Quản trị dịch vụ du lịch và lữ hành', 'code' => 'TOURM', 'department_id' => 6],
            
            // Khoa Kế toán và Kinh doanh
            ['name' => 'Tài chính - Ngân hàng', 'code' => 'FINBAN', 'department_id' => 11],
            ['name' => 'Công nghệ tài chính', 'code' => 'FINTECH', 'department_id' => 11],
            ['name' => 'Kiểm toán', 'code' => 'AUDIT', 'department_id' => 11],
            ['name' => 'Quản trị kinh doanh', 'code' => 'BA', 'department_id' => 11],
            ['name' => 'Kế toán', 'code' => 'ACC', 'department_id' => 11],
            
            // Khoa Hóa và Môi trường
            ['name' => 'Kỹ thuật môi trường', 'code' => 'ENVENG', 'department_id' => 8],
            ['name' => 'Công nghệ sinh học', 'code' => 'BIOTECH', 'department_id' => 8],
            ['name' => 'Kỹ thuật hóa học', 'code' => 'CHEMENG', 'department_id' => 8],
            
            // Khoa Luật và Lý luận chính trị
            ['name' => 'Luật', 'code' => 'LAW', 'department_id' => 9],
            ['name' => 'Luật kinh tế', 'code' => 'ECONLAW', 'department_id' => 9],
            
            // Trung tâm Đào tạo quốc tế
            ['name' => 'Ngôn ngữ Trung Quốc', 'code' => 'CHINESE', 'department_id' => 10],
            ['name' => 'Ngôn ngữ Anh', 'code' => 'ENGLISH', 'department_id' => 10],
        ];

        $classes = [];
        $classId = 1;
        $teacher_id = 41;

        // Tạo các lớp từ năm 2021 đến 2024 (khóa 63 đến 66)
        for ($year = 2021; $year <= 2024; $year++) {
            $grade = 60 + ($year - 2018); // 2021 -> 63, 2022 -> 64, 2023 -> 65, 2024 -> 66
            $academicYear = $year . '-' . ($year + 4);

            foreach ($majors as $major) {
                // Mỗi ngành có từ 1-4 lớp
                $numberOfClasses = rand(1, 3);
                
                for ($classNumber = 1; $classNumber <= $numberOfClasses; $classNumber++) {
                    $className = $grade . ' ' . $major['name'] . ' ' . $classNumber;
                    $classCode = $grade . $major['code'] . sprintf('%02d', $classNumber);
                    
                    // Truncate class_code if it's too long (ensure it's ASCII only)
                    if (strlen($classCode) > 20) {
                        $classCode = $grade . substr($major['code'], 0, 15 - strlen($grade)) . sprintf('%02d', $classNumber);
                    }
                    
                    // Truncate class_name if it's too long
                    if (strlen($className) > 100) {
                        $className = substr($className, 0, 100);
                    }

                    $classes[] = [
                        'id' => $classId++,
                        'class_code' => $classCode,
                        'class_name' => $className,
                        'department_id' => $major['department_id'],
                        'academic_year' => $academicYear,
                        'teacher_id' => $teacher_id++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert all classes in batches to avoid memory issues
        $chunks = array_chunk($classes, 300);
        foreach ($chunks as $chunk) {
            DB::table('classes')->insert($chunk);
        }
    }
}