<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default accounts per role
        User::updateOrCreate(
            ['email' => 'admin@simmas.dev'],
            [
                'name' => 'Admin SIMMAS',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru@simmas.dev'],
            [
                'name' => 'Guru SIMMAS',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@simmas.dev'],
            [
                'name' => 'Siswa SIMMAS',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'email_verified_at' => now(),
            ]
        );
    }
}
