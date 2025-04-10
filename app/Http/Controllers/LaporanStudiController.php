<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\SuratDetail;

class LaporanStudiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'keperluan' => 'required|string|max:255',
        ]);

        // Simpan data ke tabel surat
        $surat = Surat::create([
            'jenis_surat_id' => 4, // ID untuk Laporan Hasil Studi (sesuaikan dengan DB)
            'nama' => Auth::user()->nama,
            'nrp' => Auth::user()->mahasiswa->nrp,
            'keperluan' => $request->keperluan,
            'user_id' => Auth::id(),
        ]);

        SuratDetail::create([
            'surat_id' => $surat->id,
            'status' => 'diproses', // Status default saat surat diajukan
        ]);

        return redirect()->back()->with('success', 'Surat Laporan Hasil Studi berhasil diajukan.');
    }
}
