<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'content',
        'description',
        'views'
    ];


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_categories');
    }
    public function images()
    {
        return $this->belongsToMany('App\Models\Image', 'article_images');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tags');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
