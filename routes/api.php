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


    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');


    Route::post('/friend/{user}', [FriendshipController::class, 'sendRequest'])->name('friend.sendRequest');
    Route::post('/friend/{friendship}/accept', [FriendshipController::class, 'acceptRequest'])->name('friend.acceptRequest');
    Route::post('/friend/{friendship}/decline', [FriendshipController::class, 'declineRequest'])->name('friend.declineRequest');
    Route::get('/friends', [FriendshipController::class, 'showFriends'])->name('friends.index');

});
