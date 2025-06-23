<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NotificationCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'display_order',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'category_id');
    }
}
