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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id', 'id');
    }
    
    public function classWithDetails()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id')->with(['department', 'teacherWithUser']);
    }

    
}
