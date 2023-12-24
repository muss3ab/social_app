<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        auth()->user()->sentFriendRequests()->create(['friend_id' => $user->id]);
        return response()->json(['message'=>'Friend request sent successfully']);
    }

    public function acceptRequest(Friendship $friendship)
    {
        $friendship->update(['status' => 'accepted']);
        return response()->json(['message'=>'Friend request accepted!']);
    }

    public function declineRequest(Friendship $friendship)
    {
        $friendship->delete();
        return response()->json(['message'=>'Friend request declined!']);

    }

    public function showFriends()
    {
        $friends = auth()->user()->friends;
        return response()->json(['friends'=> $friends]);
    }
}
