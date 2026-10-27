<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gcmagazine.edu',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
            'bio' => 'System administrator for GC Magazine',
            'email_verified_at' => now(),
        ]);

        // Create regular users
        $users = [
            [
                'name' => 'John Editor',
                'email' => 'editor@gcmagazine.edu',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'bio' => 'Senior editor for GC Magazine',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Writer',
                'email' => 'sarah@gcmagazine.edu',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'bio' => 'Staff writer specializing in campus events',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Contributor',
                'email' => 'mike@gcmagazine.edu',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'bio' => 'Contributing writer and photographer',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}