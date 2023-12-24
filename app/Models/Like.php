<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class Like extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
    protected static function morphModels(): array
    {
        return [
            'comment' => Comment::class,
            'post' => Post::class,
        ];
    }
}
