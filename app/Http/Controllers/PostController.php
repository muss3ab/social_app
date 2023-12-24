<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;


use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return PostResource::collection($posts);
    }

    public function my_posts()
    {
        return PostResource::collection(auth()->user()->posts()->latest()->paginate(10));
    }
    public function user_posts(User $user)
    {
        return PostResource::collection($user->posts()->latest()->paginate(10));
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store(Request $request)
    {
       $validated=  $request->validate([
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'video' => 'nullable|mimes:mp4,avi,wmv,mov|max:20480',
        ]);
        try {
            DB::beginTransaction();
            $post = Post::create([
                'user_id' => auth()->id(),
                'content' => $request->input('content'),
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('post_images', 'public');
                $post->image = $imagePath;
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('post_videos', 'public');
                $post->video = $videoPath;
            }

            $post->save();
            DB::commit();
            return new PostResource($post);
        } catch (\Throwable $th) {
            report($throwable);
            return response([
                'message' => 'Something went wrong! try again later',
            ], 500);
        }

    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'video' => 'nullable|mimes:mp4,avi,wmv,mov|max:20480',
        ]);

        try {
            DB::beginTransaction();
            $post->content = $request->input('content');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('post_images', 'public');
                // Remove old image
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $post->image = $imagePath;
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('post_videos', 'public');
                // Remove old video
                if ($post->video) {
                    Storage::disk('public')->delete($post->video);
                }
                $post->video = $videoPath;
            }

            $post->update();
            DB::commit();

            return new PostResource($post);
        } catch (\Throwable $th) {
            report($throwable);
            return response([
                'message' => 'Something went wrong! try again later',
            ], 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            if ($post->video) {
                Storage::disk('public')->delete($post->video);
            }

            $post->likes()->delete();
            $post->comments()->delete();
            $post->delete();
            DB::commit();
            return response()->json(['message' => 'Post deleted']);
        } catch (\Throwable $th) {
            report($throwable);
            return response([
                'message' => 'Something went wrong! try again later',
            ], 500);
        }
    }

    public function like(Post $post)
    {
        $post->likes()->create(['user_id' => auth()->id(),'post_id'=>$post->id]);
        return response()->json(['message' => 'Post liked']);
    }

    public function unlike(Post $post ,Like $like)
    {
        $post->likes()->where('user_id', auth()->id())->delete();
        return response()->json(['message' => 'Post unliked']);
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'post_id'=>$post->id
        ]);

        return response()->json(['message' => 'Comment created']);
    }

    public function uncomment(Request $request, Comment $comment )
    {
        if($comment->user_id != auth()->id()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment Deleted']);
    }
}
