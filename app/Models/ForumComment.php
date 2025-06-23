<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'is_anonymous',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
   
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  
    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
