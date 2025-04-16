<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;
use App\Models\JenisSurat;
use App\Models\SuratDetail;
use App\Models\Notification;

class MhsAktifController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input sesuai kolom di tabel surat
        $request->validate([
            'semester' => 'required|string|max:15', // String karena ada format "Ganjil/Genap"
            'alamat' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
        ]);


        // Simpan data ke tabel surat
        $surat = Surat::create([
            'jenis_surat_id' => 1, // ID untuk Surat Keterangan Mahasiswa Aktif
            'nama' => Auth::user()->nama, // Ambil nama dari user yang login
            'semester' => $request->semester,
            'keperluan' => $request->keperluan,
            'user_id' => Auth::id(), // Ambil ID user yang login
        ]);

        SuratDetail::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
        ]);

        Notification::create([
            'user_id' => Auth::id(),      // mahasiswa yang mengajukan
            'surat_id' => $surat->id,
            'is_read' => false,
        ]);
        

        return redirect()->back()->with('success', 'Surat berhasil diajukan.');
    }
}
