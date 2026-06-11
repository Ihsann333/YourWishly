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
        User::create([
            'name' => 'Admin Wishly',
            'email' => 'admin@wishly.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Seed Regular User
        User::create([
            'name' => 'User Wishly',
            'email' => 'user@wishly.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
