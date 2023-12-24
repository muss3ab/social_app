<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function show(User $user)
    {
        return new UserResource($user);
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);
        try {
            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                // Remove old image
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                $user->profile_picture = $imagePath;
            }

            $user->bio = $request->input('bio');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->country = $request->input('country');
            $user->city = $request->input('city');

            $user->update();

            return new UserResource($user);


        } catch (\Throwable $th) {
            report($throwable);
            return response([
                'message' => 'Something went wrong! try again later',
            ], 500);
        }

    }

}
