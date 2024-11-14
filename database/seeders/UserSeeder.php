<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {

        $profileImageUrl = 'https://www.pngmart.com/files/21/Admin-Profile-PNG-Clipart.png';

        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'phone_number' => '081234567890',
                'role' => 'Administrator',
                'password' => Hash::make('password'),
                'foto_profile' => $profileImageUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'phone_number' => '081234567890',
                'role' => 'User',
                'password' => Hash::make('password123'),
                'foto_profile' => $profileImageUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'email_verified_at' => now(),
                'phone_number' => '081234567890',
                'role' => 'User',
                'password' => Hash::make('password123'),
                'foto_profile' => $profileImageUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
