<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\SuratDetail;


class MhsLulusController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tgl_lulus' => 'required|date',
        ]);

        // Simpan data ke tabel surat
        $surat = Surat::create([
            'jenis_surat_id' => 3, // ID untuk Surat Keterangan Lulus
            'nama' => Auth::user()->nama,
            'nrp' => Auth::user()->mahasiswa->nrp,
            'tgl_lulus' => $request->tgl_lulus,
            'user_id' => Auth::id(),
        ]);

        SuratDetail::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
        ]);

        return redirect()->back()->with('success', 'Surat Keterangan Lulus berhasil diajukan.');
    }
}
