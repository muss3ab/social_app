<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class,'videoable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function scopeWithLikes($query)
    {
        return $query->withCount('likes');
    }

    public function scopeWithComments($query)
    {
        return $query->withCount('comments');
    }

    public function scopeWithImages($query)
    {
        return $query->withCount('images');
    }

    public function scopeWithVideos($query)
    {
        return $query->withCount('videos');
    }

}
