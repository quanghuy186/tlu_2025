<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'department_id',
        'user_id',
        'teacher_code',
        'academic_rank',
        'specialization',
        'position',
        'office_location',
        'office_hours',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
}
