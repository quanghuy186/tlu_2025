<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_code',
        'class_name',
        'department_id',
        'academic_year',
        'semester',
        'homeroom_teacher_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id', 'id');
    }
}
