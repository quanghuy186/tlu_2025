<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory; 
    protected $table = 'departments';
    protected $fillable = [
        'name',
        'code',
        'parent_id',
        'user_id',
        'description',
        'phone',
        'email',
        'address',
        'level',
    ];
    protected $casts = [
        'level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id')
            ->orderBy('name');
    }

    public function teachers(){
        return $this->hasMany(Teacher::class, 'department_id', 'id');
    }

    //tổng gv
    public function getTotalTeachersCountAttribute()
    {
        $count = $this->teachers()->count();
        if ($this->children->count() > 0) {
            foreach ($this->children as $child) {
                $count += $child->total_teachers_count;
            }
        }
        return $count;
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHierarchical($query)
    {
        return $query->orderBy('level')->orderBy('name');
    }

    public static function getHierarchy()
    {
        return self::with('descendants')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }
    public static function getSelectOptions()
    {
        $departments = self::orderBy('level')
            ->orderBy('name')
            ->get();
        
        $options = [];
        
        foreach ($departments as $department) {
            $prefix = str_repeat('— ', $department->level);
            $options[$department->id] = $prefix . $department->name;
        }
        
        return $options;
    }

    public static function generateCode($name)
    {
        $words = explode(' ', $name);
        $code = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $code .= mb_strtoupper(mb_substr($word, 0, 1));
            }
        }
        
        if (strlen($code) < 2) {
            $code = 'D' . $code;
        }
        
        $similar = self::where('code', 'like', $code . '%')
            ->orderBy('code', 'desc')
            ->first();
            
        if ($similar) {
            preg_match('/(\d+)$/', $similar->code, $matches);
            
            if (isset($matches[1])) {
                $number = (int)$matches[1] + 1;
            } else {
                $number = 1;
            }
            
            $code .= $number;
        } else {
            $code .= '1';
        }
        
        return $code;
    }

    public function getFullPathAttribute()
    {
        $path = $this->name;
        $current = $this;
        
        while ($current->parent) {
            $current = $current->parent;
            $path = $current->name . ' / ' . $path;
        }
        
        return $path;
    }

    public function getManagerNameAttribute()
    {
        return $this->manager ? $this->manager->name : null;
    }

    public function getManagerEmailAttribute()
    {
        return $this->manager ? $this->manager->email : null;
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4e73df&color=ffffff&size=150';
    }

    public function getInitialAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}