<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
      public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User thường
        DB::table('users')->insert([
            'name' => 'Thanh Binh',
            'email' => 'thanhbinh2k5@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
    }
}
