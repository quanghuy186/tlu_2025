<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy danh sách giáo viên (teachers) để làm chủ nhiệm
        $teachers = DB::table('teachers')->pluck('id')->toArray();
        $usedTeachers = []; // Đảm bảo mỗi giáo viên chỉ chủ nhiệm 1 lớp
        
        // Lấy danh sách departments (bộ môn) - level 3 từ DepartmentSeeder
        $departments = DB::table('departments')
            ->where('level', 3)
            ->get()
            ->keyBy('code');
        
        // Mapping chính xác với DepartmentSeeder - các bộ môn
        $departmentMapping = [
            // Bộ môn thuộc Khoa CNTT
            'CNPM' => 'CNPM',  // Bộ môn Công nghệ phần mềm
            'HTTT' => 'HTTT',  // Bộ môn Hệ thống thông tin
            'TTNT' => 'TTNT',  // Bộ môn Trí tuệ nhân tạo
            
            // Bộ môn thuộc Khoa Điện - Điện tử
            'KTD' => 'KTD',    // Bộ môn Kỹ thuật điện
            'TDH' => 'TDH',    // Bộ môn Tự động hóa
            'DTVT' => 'DTVT',  // Bộ môn Điện tử viễn thông
            
            // Bộ môn thuộc Khoa Kinh tế và Quản lý
            'QTKD' => 'QTKD',  // Bộ môn Quản trị kinh doanh
            'TCNH' => 'TCNH',  // Bộ môn Tài chính ngân hàng
            
            // Bộ môn thuộc Khoa Kỹ thuật Xây dựng
            'KCCT' => 'KCCT',  // Bộ môn Kết cấu công trình
            'DKT' => 'DKT',    // Bộ môn Địa kỹ thuật
            
            // Bộ môn thuộc Khoa Thủy lợi
            'THLC' => 'THLC',  // Bộ môn Thủy lực
            'CTT' => 'CTT'     // Bộ môn Công trình thủy
        ];
        
        // Năm học từ 2021-2025 (63-67)
        $academicYears = [
            2021 => '63', // Sinh viên nhập học 2021, mã lớp 63
            2022 => '64', // Sinh viên nhập học 2022, mã lớp 64  
            2023 => '65', // Sinh viên nhập học 2023, mã lớp 65
            2024 => '66', // Sinh viên nhập học 2024, mã lớp 66
            2025 => '67'  // Sinh viên nhập học 2025, mã lớp 67
        ];
        
        // Tạo lớp cho từng năm học
        foreach ($academicYears as $academicYear => $yearCode) {
            // Tạo lớp cho từng department (bộ môn)
            foreach ($departmentMapping as $deptCode => $classPrefix) {
                // Kiểm tra department có tồn tại không
                if (!isset($departments[$deptCode])) {
                    continue;
                }
                
                $departmentId = $departments[$deptCode]->id;
                $departmentName = $departments[$deptCode]->name;
                
                // Mỗi bộ môn có 2-3 lớp
                $classCount = in_array($deptCode, ['CNPM', 'HTTT', 'KTD', 'QTKD']) ? 3 : 2;
                
                for ($classNumber = 1; $classNumber <= $classCount; $classNumber++) {
                    // Kiểm tra còn giáo viên để làm chủ nhiệm không
                    if (empty($teachers) || count($usedTeachers) >= count($teachers)) {
                        break 3; // Thoát khỏi tất cả vòng lặp nếu hết giáo viên
                    }
                    
                    // Chọn giáo viên chủ nhiệm ngẫu nhiên (chưa được sử dụng)
                    $availableTeachers = array_diff($teachers, $usedTeachers);
                    if (empty($availableTeachers)) {
                        break 3; // Thoát nếu hết giáo viên available
                    }
                    
                    $teacherId = $faker->randomElement($availableTeachers);
                    $usedTeachers[] = $teacherId;
                    
                    // Tạo mã lớp: VD 63CNPM1, 64HTTT2, 65KTD3
                    $classCode = $yearCode . $classPrefix . $classNumber;
                    
                    // Tạo tên lớp đầy đủ
                    $className = "Lớp {$classCode} - {$departmentName}";
                    
                    // Insert vào bảng classes - khớp với cấu trúc database
                    DB::table('classes')->insert([
                        'class_code' => $classCode,                    // string(20)
                        'class_name' => $className,                    // string(100)
                        'department_id' => $departmentId,              // unsignedBigInteger, nullable
                        'academic_year' => (string)$academicYear,      // string(20) - convert to string
                        'teacher_id' => $teacherId,                    // unsignedBigInteger, nullable
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Tạo thêm một số lớp chuyên biệt cho các department khác (nếu có)
        $this->createAdditionalClasses($faker, $teachers, $usedTeachers, $academicYears, $departments);
    }
    
    /**
     * Tạo thêm các lớp cho department khác hoặc lớp đặc biệt
     */
    private function createAdditionalClasses($faker, $teachers, &$usedTeachers, $academicYears, $departments)
    {
        // Lấy các department khác ngoài bộ môn chính (có thể là khoa level 2 hoặc phòng ban)
        $otherDepartments = DB::table('departments')
            ->where('level', 2)
            ->get();
        
        // Nếu có department khác, tạo ít lớp hơn (1 lớp mỗi department)
        foreach ($otherDepartments as $dept) {
            foreach ($academicYears as $academicYear => $yearCode) {
                // Chỉ tạo 1 lớp cho mỗi department cấp 2
                
                // Kiểm tra còn giáo viên
                $availableTeachers = array_diff($teachers, $usedTeachers);
                if (empty($availableTeachers)) {
                    return; // Thoát nếu hết giáo viên
                }
                
                $teacherId = $faker->randomElement($availableTeachers);
                $usedTeachers[] = $teacherId;
                
                // Tạo mã lớp với tên viết tắt của department
                $deptPrefix = $this->createDeptPrefix($dept->code);
                $classCode = $yearCode . $deptPrefix . '1';
                $className = "Lớp {$classCode} - {$dept->name}";
                
                DB::table('classes')->insert([
                    'class_code' => $classCode,
                    'class_name' => $className,
                    'department_id' => $dept->id,
                    'academic_year' => (string)$academicYear,      // Convert to string
                    'teacher_id' => $teacherId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Tạo một số lớp cao học (Graduate) cho các bộ môn chính
        $this->createGraduateClasses($faker, $teachers, $usedTeachers, $academicYears, $departments);
    }
    
    /**
     * Tạo prefix cho department từ code hoặc name
     */
    private function createDeptPrefix($deptCode)
    {
        // Các mapping đặc biệt
        $specialMapping = [
            'PDT' => 'PDT',
            'TCKT' => 'TCK',
            'CTSV' => 'CTS',
            'KHCN' => 'KHC',
            'HCTH' => 'HCT'
        ];
        
        if (isset($specialMapping[$deptCode])) {
            return $specialMapping[$deptCode];
        }
        
        // Nếu không có mapping đặc biệt, lấy 3 ký tự đầu
        return substr($deptCode, 0, 3);
    }
    
    /**
     * Tạo lớp cao học
     */
    private function createGraduateClasses($faker, $teachers, &$usedTeachers, $academicYears, $departments)
    {
        // Chỉ tạo lớp cao học cho một số bộ môn chính và từ năm 2023 trở lên
        $graduateDepts = ['CNPM', 'HTTT', 'KTD', 'KCCT', 'THLC'];
        
        foreach ($graduateDepts as $deptCode) {
            if (!isset($departments[$deptCode])) continue;
            
            $dept = $departments[$deptCode];
            
            // Chỉ tạo cho năm 2023-2025
            $graduateYears = [
                2023 => '65',
                2024 => '66', 
                2025 => '67'
            ];
            
            foreach ($graduateYears as $academicYear => $yearCode) {
                // Kiểm tra còn giáo viên
                $availableTeachers = array_diff($teachers, $usedTeachers);
                if (empty($availableTeachers)) {
                    return;
                }
                
                $teacherId = $faker->randomElement($availableTeachers);
                $usedTeachers[] = $teacherId;
                
                // Tạo mã lớp cao học: VD 65CNPMCH, 66HTTCH, 67KTDCH
                $classCode = $yearCode . $deptCode . 'CH'; // CH = Cao học
                $className = "Lớp Cao học {$classCode} - {$dept->name}";
                
                DB::table('classes')->insert([
                    'class_code' => $classCode,
                    'class_name' => $className,
                    'department_id' => $dept->id,
                    'academic_year' => (string)$academicYear,      // Convert to string
                    'teacher_id' => $teacherId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}