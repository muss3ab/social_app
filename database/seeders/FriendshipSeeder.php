<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class FriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                do {
                    $friend_id = $users->random()->id;
                } while ($friend_id == $user->id || $user->friends->contains($friend_id));

                DB::table('friendships')->insert([
                    'user_id' => $user->id,
                    'friend_id' => $friend_id,
                ]);
            }
        }

    }
}
