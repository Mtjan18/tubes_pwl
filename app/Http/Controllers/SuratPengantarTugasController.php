<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratDetail;


class SuratPengantarTugasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ditujukan_ke' => 'required|string|max:255',
            'nama_matkul' => 'required|string|max:255',
            'semester' => 'required|string|max:20',
            'data_mahasiswa' => 'required|string',
            'topik' => 'required|string',
            'tujuan_topik' => 'required|string',
        ]);

        $surat = Surat::create([
            'jenis_surat_id' => 2,
            'nama' => Auth::user()->nama,
            'nrp' => Auth::user()->mahasiswa->nrp,
            'ditujukan_ke' => $request->ditujukan_ke,
            'nama_matkul' => $request->nama_matkul,
            'semester' => $request->semester,
            'data_mahasiswa' => $request->data_mahasiswa,
            'topik' => $request->topik,
            'tujuan_topik' => $request->tujuan_topik,
            'user_id' => Auth::id(),
        ]);


        SuratDetail::create([
            'surat_id' => $surat->id,
            'status' => 'diproses',
        ]);


        return redirect()->back()->with('success', 'Pengajuan Surat Pengantar Tugas berhasil dikirim.');
    }
}
