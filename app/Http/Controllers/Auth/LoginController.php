<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan halaman login mahasiswa
    public function showMahasiswaLoginForm()
    {
        return view('auth.login_mahasiswa');
    }

    // Tampilkan halaman login pegawai
    public function showPegawaiLoginForm()
    {
        return view('auth.login_pegawai');
    }

    // Login untuk mahasiswa
    public function mahasiswaLogin(Request $request)
    {
        $credentials = $request->validate([
            'nrp' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan NRP di tabel mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('nrp', $credentials['nrp'])->first();

        if (!$mahasiswa || !Auth::attempt(['id' => $mahasiswa->user_id, 'password' => $credentials['password']])) {
            return redirect()->back()
                ->withInput($request->only('nrp'))
                ->withErrors(['nrp' => 'NRP atau password salah.']);
        }

        return redirect()->route('dashboard.mahasiswa');// Redirect ke halaman mahasiswa
    }

    public function pegawaiLogin(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $karyawan = \App\Models\Karyawan::where('nip', $credentials['nip'])->first();

        if (!$karyawan) {
            return redirect()->back()->withErrors(['nip' => 'NIP tidak ditemukan.']);
        }

        $user = $karyawan->user;

        if (!Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            return redirect()->back()
                ->withInput($request->only('nip'))
                ->withErrors(['nip' => 'Password salah.']);
        }

        // Cek role
        if ($user->role->role_name === 'ketua_prodi') {
            return redirect()->route('kaprodi.dashboard');
        } elseif ($user->role->role_name === 'karyawan') {
            return redirect()->route('karyawan.dashboard');
        } elseif ($user->role->role_name === 'admin') {
            return redirect()->route('admin.dashboard'); 
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['nip' => 'Role tidak valid untuk login.']);
        }
    }



    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

        


    