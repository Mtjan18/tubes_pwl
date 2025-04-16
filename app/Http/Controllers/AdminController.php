<?php

// AdminController.php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function index()
    {
        // Logika untuk halaman dashboard admin (misalnya menampilkan statistik, grafik, dll)
        return view('DashboardAdmin'); // Ganti dengan view yang sesuai
    }

    public function daftarMahasiswa(Request $request)
    {
        $query = Mahasiswa::query();

        if ($request->has('filter') && $request->filter != '') {
            $query->where('nrp', 'like', '%' . $request->filter . '%');
        }

        $mahasiswa = $query->with('user', 'programStudi')->get();

        // $mahasiswa = Mahasiswa::with('user', 'programStudi')->get();
        $programStudi = ProgramStudi::all();

        return view('admin.daftar-mahasiswa', compact('mahasiswa', 'programStudi'));
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:mahasiswa,nrp',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'program_studi_id' => 'required|exists:program_studi,id_program_studi',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        Mahasiswa::create([
            'nrp' => $request->nrp,
            'user_id' => $user->id,
            'program_studi_id' => $request->program_studi_id,
        ]);

        return redirect()->route('admin.daftar-mahasiswa')->with('success', 'Mahasiswa berhasil diregistrasi.');
    }



    public function updateMahasiswa(Request $request, $nrp)
    {
        $request->validate([
            'nrp' => 'required|string|max:255|unique:mahasiswa,nrp,' . $nrp . ',nrp',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $mahasiswa = Mahasiswa::where('nrp', $nrp)->firstOrFail();
        $user = $mahasiswa->user;

        // Update user info
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        // Update NRP jika berbeda
        if ($request->nrp !== $mahasiswa->nrp) {
            $mahasiswa->update([
                'nrp' => $request->nrp,
            ]);
        }

        return redirect()->route('admin.daftar-mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    public function daftarKaryawan(Request $request)
    {
        // Ambil data karyawan beserta informasi user
        $karyawan = Karyawan::with('user')
            ->when($request->has('filter'), function ($query) use ($request) {
                return $query->whereHas('user', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->filter . '%');
                });
            })
            ->when($request->role, function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    if ($request->role === 'karyawan') {
                        $q->where('role_id', 2);
                    } elseif ($request->role === 'kaprodi') {
                        $q->where('role_id', 3);
                    }
                });
            })
            ->get();

        $programStudi = ProgramStudi::all();


        // Pass data ke view
        return view('admin.daftar-karyawan', compact('karyawan', 'programStudi'));
    }


    public function updateKaryawan(Request $request, $nip)
    {
        $request->validate([
            'nip' => 'required|unique:karyawans,nip,' . $nip . '|max:20',  // Validasi NIP
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $karyawan = Karyawan::with('user')->where('nip', $nip)->first();
        $karyawan->update([
            'nip' => $request->nip, // Update NIP
        ]);
        $karyawan->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Data karyawan berhasil diperbarui.');
    }


    public function storeKaryawan(Request $request)
    {
        // Validasi inputan
        $validated = $request->validate([
            'nip' => 'required|unique:karyawan,nip|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:karyawan,kaprodi',
            'program_studi_id' => 'required_if:role,kaprodi|nullable|exists:program_studi,id_program_studi',
        ]);

        // Menyimpan data ke tabel users
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Menggunakan password dari input form
            'role_id' => $request->role == 'karyawan' ? 2 : 3, // Tambahan: jika role_id digunakan
        ]);


        // Menyimpan data karyawan
        Karyawan::create([
            'nip' => $request->nip,
            'user_id' => $user->id,
            'program_studi_id' => $request->role == 'kaprodi' ? $request->program_studi_id : null,
        ]);


        return redirect()->route('admin.daftar-karyawan')->with('success', 'Karyawan/Kaprodi berhasil ditambahkan');
    }
}
