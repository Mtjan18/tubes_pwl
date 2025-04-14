<?php

// AdminController.php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function index()
    {
        // Logika untuk halaman dashboard admin (misalnya menampilkan statistik, grafik, dll)
        return view('DashboardAdmin'); // Ganti dengan view yang sesuai
    }

    // Halaman Daftar Mahasiswa
    public function daftarMahasiswa(Request $request)
    {
        // Ambil data mahasiswa dengan relasi user dan program studi
        $mahasiswa = Mahasiswa::with('user', 'programStudi')
            ->when($request->has('filter'), function ($query) use ($request) {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->filter . '%');
                });
            })
            ->get();

        $programStudi = ProgramStudi::all();
        return view('admin.DaftarMahasiswa', compact('mahasiswa', 'programStudi'));
    }


    // Fungsi Update Mahasiswa
    public function updateMahasiswa(Request $request, $nrp)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'program_studi_id' => 'required|exists:program_studi,id_program_studi',
        ]);

        $mahasiswa = Mahasiswa::with('user')->where('nrp', $nrp)->first();
        $mahasiswa->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $mahasiswa->update([
            'program_studi_id' => $request->program_studi_id,
        ]);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
    public function daftarKaryawan(Request $request)
    {
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

        return view('admin.daftarkaryawan', compact('karyawan'));
    }

    public function updateKaryawan(Request $request, $nip)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $karyawan = Karyawan::with('user')->where('nip', $nip)->first();
        $karyawan->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Data karyawan berhasil diperbarui.');
    }
}
