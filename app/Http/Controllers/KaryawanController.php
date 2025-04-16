<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\SuratDetail;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramStudi;

class KaryawanController extends Controller
{
    public function index()
    {
        $suratDisetujui = SuratDetail::with(['surat.jenisSurat', 'surat.user'])
            ->where('status', 'disetujui')
            ->get();

        return view('DashboardKaryawan', compact('suratDisetujui'));
    }

    public function byProdi($prodi)
    {
        $prodi = strtoupper($prodi);

        $programStudi = ProgramStudi::where('id_program_studi', $prodi)->firstOrFail();

        $suratDisetujui = SuratDetail::with(['surat.jenisSurat', 'surat.user.mahasiswa.programStudi'])
            ->where('status', 'disetujui')
            ->whereHas('surat.user.mahasiswa', function ($query) use ($programStudi) {
                $query->where('program_studi_id', $programStudi->id_program_studi);
            })
            ->get();



        return view('karyawan.surat-prodi', [
            'suratDisetujui' => $suratDisetujui,
            'prodi' => $programStudi
        ]);
    }



    public function upload(Request $request, $id)
{
    $request->validate([
        'file_pdf' => 'required|mimes:pdf|max:2048',
    ]);

    $suratDetail = SuratDetail::findOrFail($id);

    $mahasiswa = $suratDetail->surat->user->mahasiswa->nrp ?? 'unknown';
    $jenisSurat = $suratDetail->surat->jenisSurat->nama ?? 'surat';
    $tanggal = now()->format('Ymd_His');
    $originalName = $request->file('file_pdf')->getClientOriginalName();

    $filename = "{$tanggal}_{$mahasiswa}_{$jenisSurat}_" . $originalName;

    $path = $request->file('file_pdf')->storeAs('pdf_surat', $filename, 'public');

    $suratDetail->file_path = $path;
    $suratDetail->processed_by = Auth::user()->id;
    $suratDetail->save();

    return back()->with('success', 'File berhasil diunggah.');
}

}
