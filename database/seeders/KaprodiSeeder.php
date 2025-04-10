<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KaprodiSeeder extends Seeder
{
    public function run()
    {

        // Insert data ke users menggunakan Eloquent
        $user = User::create([
            'nama'     => 'Anthony',
            'email'    => 'kaprodi@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 3,
        ]);

        // Insert data ke karyawan
        Karyawan::create([
            'nip'     => '7200031',
            'user_id' => $user->id, // Hubungkan dengan user
            'program_studi_id' => 'TI',
        ]);
    }
}

