<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserHasRole;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active',
        'verification_token',
        'verification_token_expiry',
        'email_verified',
    ];

    protected $hidden = [
        'password',
        'password_reset_token',
        'verification_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_verified' => 'boolean',
            'is_active' => 'boolean',
            'last_login' => 'datetime',
            'password_reset_expiry' => 'datetime',
            'verification_token_expiry' => 'datetime',
            'last_verification_resent_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
    }

    public function roles(){
        return $this->hasMany(UserHasRole::class, 'user_id', 'id');
    }

    public function hasRole($roleId)
    {
        return $this->roles()->where('role_id', $roleId)->exists();
    }

    public function hasAnyRole(array $roleIds)
    {
        return $this->roles()->whereIn('role_id', $roleIds)->exists();
    }

    public function permissions()
    {
        // Assuming you have a user_has_permissions pivot table
        return $this->hasMany(UserHasPermission::class, 'user_id', 'id');
    }

    public function managedDepartment(){
        return $this->hasOne(Department::class,'user_id', 'id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_user_id');
    }

    /**
     * Get messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_user_id');
    }

    /**
     * Get unread messages for this user.
     */
    public function unreadMessages()
    {
        return $this->receivedMessages()->where('is_read', false);
    }

    /**
     * Kiểm tra xem user có đang online không.
     */
    public function isOnline()
    {
        return $this->last_seen_at && $this->last_seen_at->diffInMinutes(now()) < 5;
    }

}
