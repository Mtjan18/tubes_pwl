<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use App\Models\User;


class AdminSeeder extends Seeder
{
    public function run()
    {
        
        Karyawan::create([
            'user_id' => '103', // Menggunakan ID yang baru dibuat
            'nip'     => '7200032',
        ]);

        // Insert data ke users menggunakan Eloquent
        User::create([
            'id'       => '103',
            'nama'     => 'Anonymouse',
            'email'    => 'admin@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 4,
        ]);
        
    }
}