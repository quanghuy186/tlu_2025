<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'message_type',
        'content',
        'file_url',
        'is_read',
        'is_deleted',
        'deleted_by_users',
        'sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_deleted' => 'boolean',
        'deleted_by_users' => 'array',
        'sent_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function isDeletedBy($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if ($this->is_deleted) {
            return true; // Nếu tin nhắn đã bị xóa hoàn toàn
        }
        
        if (empty($this->deleted_by_users)) {
            return false;
        }
        
        return in_array($userId, $this->deleted_by_users);
    }

    // Phương thức để đánh dấu tin nhắn đã bị xóa bởi người dùng cụ thể
    public function markAsDeletedBy($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        $deletedByUsers = $this->deleted_by_users ?? [];
        
        if (!in_array($userId, $deletedByUsers)) {
            $deletedByUsers[] = $userId;
            $this->deleted_by_users = $deletedByUsers;
            $this->save();
        }
        
        return $this;
    }
}