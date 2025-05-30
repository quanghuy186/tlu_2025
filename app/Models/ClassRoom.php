<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    
    /**
     * Tên bảng trong cơ sở dữ liệu
     */
    protected $table = 'classes';
    

    /**
     * Các trường có thể gán dữ liệu hàng loạt
     */
    protected $fillable = [
        'class_code',
        'class_name',
        'department_id',
        'academic_year',
        'semester',
        'teacher_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Lấy thông tin khoa/bộ môn của lớp
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Lấy thông tin giảng viên phụ trách lớp
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    
    /**
     * Lấy thông tin giảng viên kèm thông tin user
     */
    public function teacherWithUser()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->with('user');
    }
}