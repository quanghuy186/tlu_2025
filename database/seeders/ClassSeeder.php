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
        $majors = [
            ['name' => 'Kỹ thuật xây dựng công trình thủy', 'code' => 'HYDROENG', 'department_id' => 41],
            ['name' => 'Kỹ thuật xây dựng', 'code' => 'CIVENG', 'department_id' => 42],
            ['name' => 'Công nghệ kỹ thuật xây dựng', 'code' => 'CONTECH', 'department_id' => 42],
            ['name' => 'Quản lí xây dựng', 'code' => 'CONMGT', 'department_id' => 42],
            ['name' => 'Kỹ thuật xây dựng công trình giao thông', 'code' => 'TRAENG', 'department_id' => 43],
            ['name' => 'Công nghệ vật liệu xây dựng', 'code' => 'MATTECH', 'department_id' => 44],
            ['name' => 'Thủy văn học', 'code' => 'HYDRO', 'department_id' => 45],
            ['name' => 'Kỹ thuật cấp thoát nước', 'code' => 'WASUENG', 'department_id' => 46],
            ['name' => 'Kỹ thuật cơ sở hạ tầng', 'code' => 'INFENG', 'department_id' => 46],
            ['name' => 'Kỹ thuật tài nguyên nước', 'code' => 'WATRENG', 'department_id' => 47],
            ['name' => 'Kỹ thuật cơ khí', 'code' => 'MECHENG', 'department_id' => 48],
            ['name' => 'Công nghệ chế tạo máy', 'code' => 'MANTECH', 'department_id' => 49],
            ['name' => 'Kỹ thuật ô tô', 'code' => 'AUTOENG', 'department_id' => 50],
            ['name' => 'Kỹ thuật cơ điện tử', 'code' => 'MECHAENG', 'department_id' => 51],
            ['name' => 'Kỹ thuật điện', 'code' => 'ELECENG', 'department_id' => 52],
            ['name' => 'Kỹ thuật điện tử - viễn thông', 'code' => 'TELEENG', 'department_id' => 53],
            ['name' => 'Kỹ thuật điều khiển và tự động hóa', 'code' => 'AUTENG', 'department_id' => 54],
            ['name' => 'Kỹ thuật Robot và Điều khiển thông minh', 'code' => 'ROBENG', 'department_id' => 55],
            ['name' => 'Kỹ thuật phần mềm', 'code' => 'SE', 'department_id' => 56],
            ['name' => 'Hệ thống thông tin', 'code' => 'IS', 'department_id' => 57],
            ['name' => 'An toàn thông tin', 'code' => 'ISEC', 'department_id' => 58],
            ['name' => 'Công nghệ thông tin', 'code' => 'IT', 'department_id' => 59],
            ['name' => 'Trí tuệ nhân tạo và khoa học dữ liệu', 'code' => 'AIDT', 'department_id' => 59],
            ['name' => 'Thương mại điện tử', 'code' => 'ECOM', 'department_id' => 12],
            ['name' => 'Quản trị dịch vụ du lịch và lữ hành', 'code' => 'TOURM', 'department_id' => 13],
            ['name' => 'Kinh tế', 'code' => 'ECON', 'department_id' => 14],
            ['name' => 'Kinh tế xây dựng', 'code' => 'CONECON', 'department_id' => 15],
            ['name' => 'Kinh tế số', 'code' => 'DIECON', 'department_id' => 17],
            ['name' => 'Logistics và quản lí chuỗi cung ứng', 'code' => 'LSCM', 'department_id' => 18],
            ['name' => 'Kỹ thuật môi trường', 'code' => 'ENVENG', 'department_id' => 20],
            ['name' => 'Kỹ thuật hóa học', 'code' => 'CHEMENG', 'department_id' => 21],
            ['name' => 'Công nghệ sinh học', 'code' => 'BIOTECH', 'department_id' => 22],
            ['name' => 'Ngôn ngữ Anh', 'code' => 'ENGLISH', 'department_id' => 23],
            ['name' => 'Ngôn ngữ Trung Quốc', 'code' => 'CHINESE', 'department_id' => 24],
            ['name' => 'Kế toán', 'code' => 'ACC', 'department_id' => 25],
            ['name' => 'Kiểm toán', 'code' => 'AUDIT', 'department_id' => 26],
            ['name' => 'Tài chính - Ngân hàng', 'code' => 'FINBAN', 'department_id' => 27],
            ['name' => 'Công nghệ tài chính', 'code' => 'FINTECH', 'department_id' => 27],
            ['name' => 'Quản trị kinh doanh', 'code' => 'BA', 'department_id' => 28],
            ['name' => 'Luật', 'code' => 'LAW', 'department_id' => 60],
            ['name' => 'Luật kinh tế', 'code' => 'ECONLAW', 'department_id' => 61],
        ];

        $classes = [];
        $classId = 1;
        $teacher_id = 63; 

        for ($year = 2021; $year <= 2024; $year++) {
            $grade = 60 + ($year - 2018); 
            $academicYear = $year . '-' . ($year + 4);

            foreach ($majors as $major) {
                $numberOfClasses = $this->getNumberOfClasses($major['code']);
                
                for ($classNumber = 1; $classNumber <= $numberOfClasses; $classNumber++) {
                    $className = $grade . ' ' . $major['name'] . ' ' . $classNumber;
                    $classCode = $grade . $major['code'] . sprintf('%02d', $classNumber);
                    
                    if (strlen($classCode) > 20) {
                        $classCode = $grade . substr($major['code'], 0, 15 - strlen($grade)) . sprintf('%02d', $classNumber);
                    }
                    
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

        $chunks = array_chunk($classes, 300);
        foreach ($chunks as $chunk) {
            DB::table('classes')->insert($chunk);
        }
    }

    private function getNumberOfClasses($majorCode)
    {
        $popularMajors = ['IT', 'BA', 'CIVENG', 'ELECENG', 'ACC', 'FINBAN'];
        $mediumMajors = ['SE', 'MECHENG', 'ENVENG', 'ECOM', 'LAW', 'HYDROENG'];
        
        if (in_array($majorCode, $popularMajors)) {
            return rand(2, 3); 
        } elseif (in_array($majorCode, $mediumMajors)) {
            return rand(1, 2);
        } else {
            return 1; 
        }
    }
}