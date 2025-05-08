<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ForumPost;

class ForumCategory extends Model
{
    protected $table = 'forum_categories';
    
    protected $fillable = [
        'name',
        'description'
    ];

    public function posts(){
        return $this->hasMany(ForumPost::class,'category_id','id');
    }
}
