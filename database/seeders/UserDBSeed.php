<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDBSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
          "name" => "Abdallah Zain",
          "email" => "abdallahabdelrahman@gmail.com",
          "email_verified_at" => now(),
          "password" => '12345678'
        ]);
    }
}
