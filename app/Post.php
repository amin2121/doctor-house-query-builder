<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'thumbnail'];
    // protected $guard = [];
    // protected $table = 'posts';

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeLastData()
    {
        return $this->orderBy('id', 'desc')->first();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
