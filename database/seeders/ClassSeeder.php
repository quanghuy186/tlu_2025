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
        // Danh sách các ngành học theo từng bộ môn
        $majors = [
            // Khoa Công trình - Bộ môn Kỹ thuật xây dựng công trình thủy (41)
            ['name' => 'Kỹ thuật xây dựng công trình thủy', 'code' => 'HYDROENG', 'department_id' => 41],
            
            // Khoa Công trình - Bộ môn Xây dựng dân dụng và công nghiệp (42)
            ['name' => 'Kỹ thuật xây dựng', 'code' => 'CIVENG', 'department_id' => 42],
            ['name' => 'Công nghệ kỹ thuật xây dựng', 'code' => 'CONTECH', 'department_id' => 42],
            ['name' => 'Quản lí xây dựng', 'code' => 'CONMGT', 'department_id' => 42],
            
            // Khoa Công trình - Bộ môn Xây dựng cầu đường (43)
            ['name' => 'Kỹ thuật xây dựng công trình giao thông', 'code' => 'TRAENG', 'department_id' => 43],
            
            // Khoa Công trình - Bộ môn Vật liệu xây dựng (44)
            ['name' => 'Công nghệ vật liệu xây dựng', 'code' => 'MATTECH', 'department_id' => 44],
            
            // Khoa Kỹ thuật tài nguyên nước - Bộ môn Thủy văn (45)
            ['name' => 'Thủy văn học', 'code' => 'HYDRO', 'department_id' => 45],
            
            // Khoa Kỹ thuật tài nguyên nước - Bộ môn Cấp thoát nước (46)
            ['name' => 'Kỹ thuật cấp thoát nước', 'code' => 'WASUENG', 'department_id' => 46],
            ['name' => 'Kỹ thuật cơ sở hạ tầng', 'code' => 'INFENG', 'department_id' => 46],
            
            // Khoa Kỹ thuật tài nguyên nước - Bộ môn Kỹ thuật tài nguyên nước (47)
            ['name' => 'Kỹ thuật tài nguyên nước', 'code' => 'WATRENG', 'department_id' => 47],
            
            // Khoa Cơ khí - Bộ môn Kỹ thuật cơ khí (48)
            ['name' => 'Kỹ thuật cơ khí', 'code' => 'MECHENG', 'department_id' => 48],
            
            // Khoa Cơ khí - Bộ môn Công nghệ chế tạo máy (49)
            ['name' => 'Công nghệ chế tạo máy', 'code' => 'MANTECH', 'department_id' => 49],
            
            // Khoa Cơ khí - Bộ môn Kỹ thuật ô tô (50)
            ['name' => 'Kỹ thuật ô tô', 'code' => 'AUTOENG', 'department_id' => 50],
            
            // Khoa Cơ khí - Bộ môn Cơ điện tử (51)
            ['name' => 'Kỹ thuật cơ điện tử', 'code' => 'MECHAENG', 'department_id' => 51],
            
            // Khoa Điện - Điện tử - Bộ môn Kỹ thuật điện (52)
            ['name' => 'Kỹ thuật điện', 'code' => 'ELECENG', 'department_id' => 52],
            
            // Khoa Điện - Điện tử - Bộ môn Điện tử viễn thông (53)
            ['name' => 'Kỹ thuật điện tử - viễn thông', 'code' => 'TELEENG', 'department_id' => 53],
            
            // Khoa Điện - Điện tử - Bộ môn Kỹ thuật điều khiển và Tự động hóa (54)
            ['name' => 'Kỹ thuật điều khiển và tự động hóa', 'code' => 'AUTENG', 'department_id' => 54],
            
            // Khoa Điện - Điện tử - Bộ môn Robot và Trí tuệ nhân tạo (55)
            ['name' => 'Kỹ thuật Robot và Điều khiển thông minh', 'code' => 'ROBENG', 'department_id' => 55],
            
            // Khoa Công nghệ thông tin - Bộ môn Công nghệ phần mềm (56)
            ['name' => 'Kỹ thuật phần mềm', 'code' => 'SE', 'department_id' => 56],
            
            // Khoa Công nghệ thông tin - Bộ môn Hệ thống thông tin (57)
            ['name' => 'Hệ thống thông tin', 'code' => 'IS', 'department_id' => 57],
            
            // Khoa Công nghệ thông tin - Bộ môn An toàn thông tin (58)
            ['name' => 'An toàn thông tin', 'code' => 'ISEC', 'department_id' => 58],
            
            // Khoa Công nghệ thông tin - Bộ môn Khoa học máy tính (59)
            ['name' => 'Công nghệ thông tin', 'code' => 'IT', 'department_id' => 59],
            ['name' => 'Trí tuệ nhân tạo và khoa học dữ liệu', 'code' => 'AIDT', 'department_id' => 59],
            
            // Khoa Kinh tế và quản lý - Bộ môn Thương mại điện tử (12)
            ['name' => 'Thương mại điện tử', 'code' => 'ECOM', 'department_id' => 12],
            
            // Khoa Kinh tế và quản lý - Bộ môn Quản trị du lịch (13)
            ['name' => 'Quản trị dịch vụ du lịch và lữ hành', 'code' => 'TOURM', 'department_id' => 13],
            
            // Khoa Kinh tế và quản lý - Bộ môn Kinh tế (14)
            ['name' => 'Kinh tế', 'code' => 'ECON', 'department_id' => 14],
            
            // Khoa Kinh tế và quản lý - Bộ môn Kinh tế xây dựng (15)
            ['name' => 'Kinh tế xây dựng', 'code' => 'CONECON', 'department_id' => 15],
            
            // Khoa Kinh tế và quản lý - Bộ môn Kinh tế và kinh doanh số (17)
            ['name' => 'Kinh tế số', 'code' => 'DIECON', 'department_id' => 17],
            
            // Khoa Kinh tế và quản lý - Bộ môn Logistics và chuỗi cung ứng (18)
            ['name' => 'Logistics và quản lí chuỗi cung ứng', 'code' => 'LSCM', 'department_id' => 18],
            
            // Khoa Hóa và Môi trường - Bộ môn Kỹ thuật và Quản lý Môi trường (20)
            ['name' => 'Kỹ thuật môi trường', 'code' => 'ENVENG', 'department_id' => 20],
            
            // Khoa Hóa và Môi trường - Bộ môn Kỹ thuật Hóa học (21)
            ['name' => 'Kỹ thuật hóa học', 'code' => 'CHEMENG', 'department_id' => 21],
            
            // Khoa Hóa và Môi trường - Bộ môn Công nghệ Sinh học (22)
            ['name' => 'Công nghệ sinh học', 'code' => 'BIOTECH', 'department_id' => 22],
            
            // Trung tâm Đào tạo quốc tế - Bộ môn ngôn ngữ Anh (23)
            ['name' => 'Ngôn ngữ Anh', 'code' => 'ENGLISH', 'department_id' => 23],
            
            // Trung tâm Đào tạo quốc tế - Bộ môn ngôn ngữ Trung Quốc (24)
            ['name' => 'Ngôn ngữ Trung Quốc', 'code' => 'CHINESE', 'department_id' => 24],
            
            // Khoa Kế toán và Kinh doanh - Bộ môn kế toán (25)
            ['name' => 'Kế toán', 'code' => 'ACC', 'department_id' => 25],
            
            // Khoa Kế toán và Kinh doanh - Bộ môn kiểm toán (26)
            ['name' => 'Kiểm toán', 'code' => 'AUDIT', 'department_id' => 26],
            
            // Khoa Kế toán và Kinh doanh - Bộ môn tài chính (27)
            ['name' => 'Tài chính - Ngân hàng', 'code' => 'FINBAN', 'department_id' => 27],
            ['name' => 'Công nghệ tài chính', 'code' => 'FINTECH', 'department_id' => 27],
            
            // Khoa Kế toán và Kinh doanh - Bộ môn Quản trị kinh doanh (28)
            ['name' => 'Quản trị kinh doanh', 'code' => 'BA', 'department_id' => 28],
            
            // Khoa Luật và Lý luận chính trị - Bộ môn Luật (60)
            ['name' => 'Luật', 'code' => 'LAW', 'department_id' => 60],
            
            // Khoa Luật và Lý luận chính trị - Bộ môn Luật kinh tế (61)
            ['name' => 'Luật kinh tế', 'code' => 'ECONLAW', 'department_id' => 61],
        ];

        $classes = [];
        $classId = 1;
        $teacher_id = 63; // Bắt đầu từ teacher_id 63 (sau các trưởng bộ môn)

        // Tạo các lớp từ năm 2021 đến 2024 (khóa 63 đến 66)
        for ($year = 2021; $year <= 2024; $year++) {
            $grade = 60 + ($year - 2018); // 2021 -> 63, 2022 -> 64, 2023 -> 65, 2024 -> 66
            $academicYear = $year . '-' . ($year + 4);

            foreach ($majors as $major) {
                // Mỗi ngành có từ 1-3 lớp tùy theo quy mô
                $numberOfClasses = $this->getNumberOfClasses($major['code']);
                
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

    /**
     * Xác định số lượng lớp cho mỗi ngành dựa trên tính phổ biến
     */
    private function getNumberOfClasses($majorCode)
    {
        $popularMajors = ['IT', 'BA', 'CIVENG', 'ELECENG', 'ACC', 'FINBAN'];
        $mediumMajors = ['SE', 'MECHENG', 'ENVENG', 'ECOM', 'LAW', 'HYDROENG'];
        
        if (in_array($majorCode, $popularMajors)) {
            return rand(2, 3); // Ngành phổ biến: 2-3 lớp
        } elseif (in_array($majorCode, $mediumMajors)) {
            return rand(1, 2); // Ngành trung bình: 1-2 lớp
        } else {
            return 1; // Ngành ít phổ biến: 1 lớp
        }
    }
}