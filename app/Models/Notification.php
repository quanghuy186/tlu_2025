<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'user_id',
        'content',
        'images',
        'category_id'
    ];

    /**
     * Get the user that created the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the notification.
     */
    public function category()
    {
        return $this->belongsTo(NotificationCategory::class, 'category_id');
    }

    /**
     * Get the images as an array
     */
    public function getImagesArrayAttribute()
    {
        if (empty($this->images)) {
            return [];
        }
        
        return explode(',', $this->images);
    }

    /**
     * Set multiple images
     */
    public function setImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['images'] = implode(',', array_filter($value));
        } else {
            $this->attributes['images'] = $value;
        }
    }

    /**
     * Get the URL for the first image
     * Cải tiến: Kiểm tra tồn tại file trước khi trả về URL
     */
    public function getFirstImageUrlAttribute()
    {
        $images = $this->images_array;
        
        if (empty($images)) {
            return null;
        }
        
        $firstImage = $images[0];
        
        // Kiểm tra xem đường dẫn đã có domain/storage hay chưa
        if (strpos($firstImage, 'http') === 0 || strpos($firstImage, '//') === 0) {
            return $firstImage;
        }
        
        // Đảm bảo đường dẫn không có dấu "/" ở đầu để tránh lỗi
        $firstImage = ltrim($firstImage, '/');
        
        return asset('storage/' . $firstImage);
    }
    
    /**
     * Get the full URL for a specific image by index
     */
    public function getImageUrl($index = 0)
    {
        $images = $this->images_array;
        
        if (empty($images) || !isset($images[$index])) {
            return null;
        }
        
        $image = $images[$index];
        
        // Kiểm tra xem đường dẫn đã có domain/storage hay chưa
        if (strpos($image, 'http') === 0 || strpos($image, '//') === 0) {
            return $image;
        }
        
        // Đảm bảo đường dẫn không có dấu "/" ở đầu để tránh lỗi
        $image = ltrim($image, '/');
        
        return asset('storage/' . $image);
    }

    /**
     * Get the category name attribute
     */
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Chưa phân loại';
    }
}