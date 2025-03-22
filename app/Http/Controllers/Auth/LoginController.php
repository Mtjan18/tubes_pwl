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
    
        return redirect('/index'); // Redirect ke halaman mahasiswa
    }
    
    public function pegawaiLogin(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Cari user berdasarkan NIP di tabel karyawan
        $karyawan = \App\Models\Karyawan::where('nip', $credentials['nip'])->first();
    
        if (!$karyawan || !Auth::attempt(['id' => $karyawan->user_id, 'password' => $credentials['password']])) {
            return redirect()->back()
                ->withInput($request->only('nip'))
                ->withErrors(['nip' => 'NIP atau password salah.']);
        }
    
        return redirect('/index'); // Redirect ke halaman karyawan
    }
    

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

        


    // // Login untuk mahasiswa
    // public function mahasiswaLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'nrp' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt(['nrp' => $credentials['nrp'], 'password' => $credentials['password']])) {
    //         return redirect('/index_mahasiswa');
    //     }

    //     return redirect()->back()
    //         ->withInput($request->only('nrp'))
    //         ->withErrors(['nrp' => 'NRP atau password salah.']);
    // }

    // // Login untuk karyawan
    // public function pegawaiLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'nip' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt(['nip' => $credentials['nip'], 'password' => $credentials['password']])) {
    //         return redirect('/index');
    //     }

    //     return redirect()->back()
    //         ->withInput($request->only('nip'))
    //         ->withErrors(['nip' => 'NIP atau password salah.']);
    // }

    // // Handle logout
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/login');
    // }
// }
