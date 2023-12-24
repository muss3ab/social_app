<?php

namespace App\Http\Controllers;

use App\Models\comments;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
class CommentsController extends Controller
{

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $comment = new Comment;
        $comment->user_id = auth()->id();
        $comment->post_id = $postId;
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment created', 'comment' => $comment]);

    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment->content = e($validated['content']);
        $comment->save();

        return response()->json(['message' => 'Comment updated', 'comment' => $comment]);

    }

}
