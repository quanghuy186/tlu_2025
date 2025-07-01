<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    protected $table = 'classes';
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
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function teacherWithUser()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->with('user');
    }
}