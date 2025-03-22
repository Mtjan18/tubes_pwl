<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        // Buat user baru
        $user = User::create([
            'nama'     => 'Anthonius',
            'email'    => 'karyawan1@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 2, // Role karyawan
        ]);

        // Masukkan karyawan dengan NIP sebagai primary key
        Karyawan::create([
            'nip'     => '7200030', // NIP sebagai primary key
            'user_id' => $user->id, // Hubungkan dengan user
        ]);
    }
}

