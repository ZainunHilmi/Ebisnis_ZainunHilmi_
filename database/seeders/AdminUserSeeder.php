<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                // pastikan kolom 'role' ada di migration users; nilai 'admin' di sini
                'role' => 'admin',
                'password' => Hash::make('password'), // ganti setelah testing
            ]
        );
    }
}
