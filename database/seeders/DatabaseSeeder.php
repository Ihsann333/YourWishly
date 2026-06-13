<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call TemplateSeeder
        $this->call(TemplateSeeder::class);

        // Seed Admin User
        User::firstOrCreate(
            ['email' => 'admin@wishly.com'],
            [
                'name' => 'Admin Wishly',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Seed Regular User
        User::firstOrCreate(
            ['email' => 'user@wishly.com'],
            [
                'name' => 'User Wishly',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
