<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user that matches the one in the error message
        User::updateOrCreate(
            ['email' => 'xtrangheroe2@gmail.com'],
            [
                'username' => 'xtranghero',
                'full_name' => 'Divine User',
                'password' => Hash::make('password123'),
                'role' => 'user'
            ]
        );
    }
} 