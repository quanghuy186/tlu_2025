<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ForumPost;

class ForumCategory extends Model
{
    protected $table = 'forum_categories';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active'
    ];
    
    protected $attributes = [
        'is_active' => true
    ];
    
    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'category_id', 'id');
    }
    
    public function parent()
    {
        return $this->belongsTo(ForumCategory::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(ForumCategory::class, 'parent_id');
    }
    
    public function isActive()
    {
        return (bool) $this->is_active;
    }
    
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}