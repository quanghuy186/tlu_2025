<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $table = 'forum_posts';
    
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'content',
        'images',
        'status',
        'approved_by',
        'approved_at',
        'reject_reason',
        'is_anonymous',
        'view_count',
        'is_pinned',
        'is_locked',
        'last_comment_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'last_comment_at' => 'datetime',
        'is_anonymous' => 'boolean',
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

   
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Lấy người duyệt bài viết
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function parentComments()
    {
        return $this->hasMany(ForumComment::class, 'post_id')->whereNull('parent_id');
    }

    /**
     * Kiểm tra trạng thái đã duyệt
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Kiểm tra trạng thái bị từ chối
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Kiểm tra trạng thái đang chờ duyệt
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // public function views()
    // {
    //     return $this->hasMany(ForumView::class, 'post_id');
    // }

    public function likes()
    {
        return $this->hasMany(ForumLike::class, 'post_id');
    }

    public function likedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
    
    /**
     * Chuyển đổi chuỗi images thành mảng
     */
    public function getImagesArrayAttribute()
    {
        if (empty($this->images)) {
            return [];
        }
        
        return json_decode($this->images, true);
    }
}
