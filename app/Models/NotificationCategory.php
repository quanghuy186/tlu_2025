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

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate slug from name when creating if not provided
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        // Auto-update slug when name changes if not manually set
        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the notifications that belong to this category.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'category_id');
    }
}
