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

        // Insert data ke karyawan
        Karyawan::create([
            'user_id' => '102', // Menggunakan ID yang baru dibuat
            'nip'     => '7200031',
        ]);

        // Insert data ke users menggunakan Eloquent
        User::create([
            'id'       => '102',
            'nama'     => 'Anthony',
            'email'    => 'kaprodi@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 3,
        ]);

        
    }
}

