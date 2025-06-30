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
        'category_id',
        'is_pinned'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(NotificationCategory::class, 'category_id');
    }

    public function getImagesArrayAttribute()
    {
        if (empty($this->images)) {
            return [];
        }
        
        return explode(',', $this->images);
    }

    public function setImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['images'] = implode(',', array_filter($value));
        } else {
            $this->attributes['images'] = $value;
        }
    }

    public function getFirstImageUrlAttribute()
    {
        $images = $this->images_array;
        
        if (empty($images)) {
            return null;
        }
        
        $firstImage = $images[0];
        
        if (strpos($firstImage, 'http') === 0 || strpos($firstImage, '//') === 0) {
            return $firstImage;
        }
        
        $firstImage = ltrim($firstImage, '/');
        
        return asset('storage/' . $firstImage);
    }
    
    public function getImageUrl($index = 0)
    {
        $images = $this->images_array;
        
        if (empty($images) || !isset($images[$index])) {
            return null;
        }
        
        $image = $images[$index];
        
        if (strpos($image, 'http') === 0 || strpos($image, '//') === 0) {
            return $image;
        }
        
        $image = ltrim($image, '/');
        
        return asset('storage/' . $image);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Chưa phân loại';
    }

     public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}