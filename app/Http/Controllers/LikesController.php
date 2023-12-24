<?php

namespace App\Http\Controllers;

use App\Models\likes;
use Illuminate\Http\Request;
use App\Models\Post;
class LikesController extends Controller
{
    public function like($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->likes()->attach(auth()->id());

        return response()->json(['message' => 'Post liked']);
    }
}
