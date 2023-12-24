<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/auth/{google}', [AuthController::class, 'redirectToProvider']);
Route::get('/auth/{google}/callback', [AuthController::class, 'handleProviderCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('/feeds', [PostController::class, 'index'])->name('posts.index');
    Route::get('/show-post/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/myposts', [PostController::class, 'my_posts'])->name('posts.my_posts');
    Route::get('/posts/{user}', [PostController::class, 'user_posts'])->name('posts.user');

    // creation and update of posts
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/delete/{post}', [PostController::class, 'destroy'])->name('posts.delete');

    // interaction with posts
    Route::post('/posts/like/{post}', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/unlike/{like}', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/comment/{post}', [PostController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/uncomment/{comment}', [PostController::class, 'uncomment'])->name('posts.uncomment');


    Route::post('/friend/{user}', [FriendshipController::class, 'sendRequest'])->name('friend.sendRequest');
    Route::post('/friend/{friendship}/accept', [FriendshipController::class, 'acceptRequest'])->name('friend.acceptRequest');
    Route::post('/friend/{friendship}/decline', [FriendshipController::class, 'declineRequest'])->name('friend.declineRequest');
    Route::get('/friends', [FriendshipController::class, 'showFriends'])->name('friends.index');

});
