<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function edit()
    {
        $user = auth()->user();

        return response()->json($user);
    }

    public function update(Request $request)
    {

        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:255',
            'contact_details' => 'nullable|string|max:255',
        ]);
        try {
            $user = auth()->user();

            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $imagePath;
            }
            $user->bio = $request->input('bio');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->country = $request->input('country');
            $user->city = $request->input('city');

            $user->save();

            return response()->json($user);

        } catch (\Throwable $th) {
            report($throwable);
            return response([
                'message' => 'Something went wrong! try again later',
            ], 500);
        }

    }

}
