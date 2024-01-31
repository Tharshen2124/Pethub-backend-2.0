<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "category_id";

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'category_news', 'category_id', 'news_id');
    }
}
