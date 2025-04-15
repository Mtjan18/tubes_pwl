<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\SuratDetail;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index()
    {
        $suratDisetujui = SuratDetail::with(['surat.jenisSurat', 'surat.user'])
            ->where('status', 'disetujui')
            ->get();

        return view('DashboardKaryawan', compact('suratDisetujui'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $suratDetail = SuratDetail::findOrFail($id);
        $path = $request->file('file_pdf')->store('pdf_surat');

        $suratDetail->file_path = $path;
        $suratDetail->processed_by = Auth::user()->id;
        $suratDetail->save();

        return back()->with('success', 'File berhasil diunggah.');
    }
}

