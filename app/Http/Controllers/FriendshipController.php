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

        $friendship = Friendship::where('user_id', auth()->id())->where('friend_id', $user->id)->first();
        if($friendship)
        {
            if($friendship->status == 'pending')
                return response()->json(['message'=>'Friend request already sent!']);

        }else {
            Friendship::create([
                'user_id'=> auth()->id(),
                'friend_id'=> $user->id,
            ]);
        }
        return response()->json(['message'=>'Friend request sent successfully']);
    }

    public function acceptRequest(Friendship $friendship)
    {
        if($friendship->friend_id == auth()->id()){
            $friendship->update(['status' => 'accepted']);

        }else {
            return response()->json(['message'=>'No Request Found !']);
        }
        return response()->json(['message'=>'Friend request accepted!']);
    }

    public function declineRequest(Friendship $friendship)
    {

        if($friendship->friend_id == auth()->id() && $friendship->status == 'pending'){
            $friendship->update(['status' => 'declined']);

        } elseif ($friendship->user_id == auth()->id() && $friendship->status == 'pending') {
            $friendship->update(['status' => 'declined']);
        }else{
            return response()->json(['message'=>'No Request Found !']);
        }

        return response()->json(['message'=>'Friend request declined!']);

    }
    public function showRequests(Request $request)
    {
        $friendship = Friendship::where('friend_id', auth()->id())->where('status', 'pending')->get();
        return response()->json(['friendship'=> $friendship]);

    }
    public function MyFriendsRequests(Request $request)
    {

        $friendship = Friendship::where('user_id', auth()->id())->where('status', 'pending')->get();
        return response()->json(['friendship'=> $friendship]);

    }
    public function showFriends(Request $request)
    {
        $friends = auth()->user()->friends;
        return response()->json(['friends'=> $friends]);
    }
}
