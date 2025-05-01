<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'class_id',
        'student_code',
        'enrollment_year',
        'program',
        'graduation_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy thông tin lớp học của sinh viên
     */
    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    
    /**
     * Lấy thông tin lớp học kèm theo khoa và giảng viên
     */
    public function classWithDetails()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id')->with(['department', 'teacherWithUser']);
    }
    
    /**
     * Danh sách trạng thái tốt nghiệp có thể có
     */
    public static function getGraduationStatuses()
    {
        return [
            'studying' => 'Đang học',
            'graduated' => 'Đã tốt nghiệp',
            'suspended' => 'Đình chỉ học',
            'dropped' => 'Bỏ học',
            'transferred' => 'Chuyển trường',
        ];
    }
    
    /**
     * Lấy tên trạng thái tốt nghiệp hiển thị
     */
    public function getGraduationStatusName()
    {
        $statuses = self::getGraduationStatuses();
        return isset($statuses[$this->graduation_status]) ? $statuses[$this->graduation_status] : 'Không xác định';
    }
    
    /**
     * Lấy danh sách các chương trình học
     */
    public static function getPrograms()
    {
        return [
            'standard' => 'Chương trình chuẩn',
            'advanced' => 'Chương trình tiên tiến',
            'international' => 'Chương trình quốc tế',
            'high_quality' => 'Chương trình chất lượng cao',
            'distance' => 'Đào tạo từ xa',
        ];
    }
    
    /**
     * Lấy tên chương trình học hiển thị
     */
    public function getProgramName()
    {
        $programs = self::getPrograms();
        return isset($programs[$this->program]) ? $programs[$this->program] : 'Không xác định';
    }
}
