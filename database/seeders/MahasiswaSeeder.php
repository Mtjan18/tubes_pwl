<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        // Buat user baru
        $user = User::create([
            'nama'     => 'Budi Santoso',
            'email'    => 'mahasiswa1@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 1, // Role mahasiswa
        ]);

        // Masukkan mahasiswa dengan NRP sebagai primary key
        Mahasiswa::create([
            'nrp'              => '2327030', // NRP sebagai primary key
            'user_id'          => $user->id, // Hubungkan dengan user
            'program_studi_id' => 'TI',
        ]);
    }
}

