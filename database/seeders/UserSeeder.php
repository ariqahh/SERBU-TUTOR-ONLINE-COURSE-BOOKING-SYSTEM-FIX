<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role admin, mentor, mentee
        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mentor 1', 'email' => 'mentor1@gmail.com', 'password' => Hash::make('mentor1'), 'role' => 'mentor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mentor 2', 'email' => 'mentor2@gmail.com', 'password' => Hash::make('mentor2'), 'role' => 'mentor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mentee 1', 'email' => 'mentee1@gmail.com', 'password' => Hash::make('mentee1'), 'role' => 'mentee', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mentee 2', 'email' => 'mentee2@gmail.com', 'password' => Hash::make('mentee2'), 'role' => 'mentee', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
