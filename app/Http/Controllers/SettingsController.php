<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles->role_name;

        $data = [
            'nama' => $user->nama,
            'email' => $user->email,
            'dibuat_pada' => $user->created_at->format('d-m-Y H:i'),
            'profile_image' => asset('images/default-profile.png'), // Gambar profil statis
        ];

        if ($role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if ($mahasiswa) {
                // Ambil nama program studi langsung dari database
                $programStudi = DB::table('program_studi')
                                ->where('id_program_studi', $mahasiswa->program_studi_id)
                                ->value('nama_program_studi');

                $data['nrp'] = $mahasiswa->nrp;
                $data['program_studi'] = $programStudi ?? '-';
            }
        } elseif ($role === 'karyawan' || $role === 'ketua_prodi') {
            $karyawan = Karyawan::where('user_id', $user->id)->first();
            if ($karyawan) {
                $data['nip'] = $karyawan->nip;
            }
            if ($role === 'ketua_prodi') {
                $data['program_studi'] = 'Ketua Program Studi';
            }
        }

        return view('settings', compact('data', 'role'));
    }
}
