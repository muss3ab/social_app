<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => bcrypt('password'),
                'profile_picture' => null,
                'bio' => Str::random(50),
                'phone' => '1234567890',
                'address' => Str::random(20),
                'country' => 'USA',
                'city' => 'New York',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
