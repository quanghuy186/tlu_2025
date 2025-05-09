<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'content',
        'is_anonymous',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the post that the comment belongs to.
     */
    public function post()
    {
        return $this->belongsTo(ForumPost::class);
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment.
     */
    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_comment_id');
    }

    /**
     * Get the replies to this comment.
     */
    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_comment_id');
    }

    /**
     * Scope a query to only include top-level comments (no parent comment).
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_comment_id');
    }

    /**
     * Check if comment has replies.
     */
    public function hasReplies()
    {
        return $this->replies()->count() > 0;
    }
}
