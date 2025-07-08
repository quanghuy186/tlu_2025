<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'reason',
        'status',
        'notes'
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Chờ xử lý</span>',
            'resolved' => '<span class="badge bg-success">Đã xử lý</span>',
            'rejected' => '<span class="badge bg-danger">Từ chối</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Không xác định</span>';
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    // Methods
    public function markAsResolved($notes = null)
    {
        $this->update([
            'status' => 'resolved',
            'notes' => $notes
        ]);
    }

    public function markAsRejected($notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $notes
        ]);
    }
}