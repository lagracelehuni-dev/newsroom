<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Post extends Model
{

    use HasFactory;

    protected $fillable = [
        'title', 'content', 'slug', 'user_id', 'category_id', 'reading_time', 'cover_image', 'published_at', 'views_count', 'shares_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getSharesCountAttribute()
    {
        return $this->shares()->count();
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    protected $appends = ['likes_count', 'comments_count'];
}
