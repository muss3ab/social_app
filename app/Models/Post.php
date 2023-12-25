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
    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function scopeWithLikes($query)
    {
        $query->leftJoinSub(
            'select post_id, sum(liked) likes, sum(!liked) dislikes from likes group by post_id',
            'likes',
            'likes.post_id',
            'posts.id'
        );
    }

}
