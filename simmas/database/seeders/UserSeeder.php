<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guruUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $guruUser->id,
            'nip' => '1987654321',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Pendidikan No. 123',
            'telepon' => '081234567890',
        ]);

        // Siswa
        $siswaUser = User::create([
            'name' => 'Ani Wijaya',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $siswaUser->id,
            'nama' => 'Ani Wijaya',
            'nis' => '20230001',
            'kelas' => 'XI RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'alamat' => 'Jl. Merdeka No. 45',
            'telepon' => '089876543210',
        ]);
    }
}
