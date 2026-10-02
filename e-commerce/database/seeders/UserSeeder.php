<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'admin1',
            'email' => 'admin123@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]); 

        // Customer users
        User::create([
            'name' => 'user1',
            'email' => 'user123@example.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'seller1',
            'email' => 'seller123@example.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);
    }
}
