<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\SuratDetail;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramStudi;
use App\Models\JenisSurat;

class KaryawanController extends Controller
{
    public function index()
    {
        $suratDisetujui = SuratDetail::with(['surat.jenisSurat', 'surat.user'])
            ->where('status', 'disetujui')
            ->get();

        return view('DashboardKaryawan', compact('suratDisetujui'));
    }

    

    public function byProdi($prodi, Request $request)
    {
        $prodi = strtoupper($prodi);
        $programStudi = ProgramStudi::where('id_program_studi', $prodi)->firstOrFail();

        $jenisSuratList = JenisSurat::all(); // ambil semua jenis surat

        $query = SuratDetail::with(['surat.jenisSurat', 'surat.user.mahasiswa.programStudi'])
            ->where('status', 'disetujui')
            ->whereHas('surat.user.mahasiswa', function ($query) use ($programStudi) {
                $query->where('program_studi_id', $programStudi->id_program_studi);
            });

        if ($request->filled('nrp')) {
            $query->whereHas('surat.user.mahasiswa', function ($q) use ($request) {
                $q->where('nrp', 'like', '%' . $request->nrp . '%');
            });
        }

        if ($request->filled('jenis_surat')) {
            $query->whereHas('surat.jenisSurat', function ($q) use ($request) {
                $q->where('id', $request->jenis_surat);
            });
        }

        $suratDisetujui = $query->get();

        return view('karyawan.surat-prodi', [
            'suratDisetujui' => $suratDisetujui,
            'prodi' => $programStudi,
            'jenisSuratList' => $jenisSuratList,
        ]);
    }




    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $suratDetail = SuratDetail::findOrFail($id);

        // Hapus file lama jika ada
        if ($suratDetail->file_path && Storage::disk('public')->exists($suratDetail->file_path)) {
            Storage::disk('public')->delete($suratDetail->file_path);
        }

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
