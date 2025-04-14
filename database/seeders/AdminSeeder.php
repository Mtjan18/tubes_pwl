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

        // Insert data ke users menggunakan Eloquent
        $user = User::create([
            'nama'     => 'Admin',
            'email'    => 'Admin@example.com',
            'password' => Hash::make('12345'),
            'role_id'  => 4,
        ]);

        // Insert data ke karyawan
        Karyawan::create([
            'nip'     => '7200032',
            'user_id' => $user->id, // Hubungkan dengan user
        ]);
    }
}