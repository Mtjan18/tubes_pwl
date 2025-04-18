<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratDetailController extends Controller
{
    public function index()
    {
        $suratDetails = DB::table('surat_detail')
            ->join('surat', 'surat_detail.surat_id', '=', 'surat.id')
            ->join('jenis_surat', 'surat.jenis_surat_id', '=', 'jenis_surat.id')
            ->join('users as mahasiswa', 'surat.user_id', '=', 'mahasiswa.id') 
            ->leftJoin('users as kaprodi', 'surat_detail.approved_by', '=', 'kaprodi.id')
            ->leftJoin('users as karyawan', 'surat_detail.processed_by', '=', 'karyawan.id')
            ->select(
                'surat_detail.*',
                'surat.nama as nama_surat',
                'jenis_surat.nama_jenis as jenis_surat_nama',
                'mahasiswa.nama as nama_pengaju',
                'surat.created_at as tanggal_diajukan',
                'kaprodi.nama as nama_kaprodi',
                'karyawan.nama as nama_karyawan'
            )
            ->get();

        return view('Mahasiswa.SuratDetail', compact('suratDetails'));
    }

    public function destroy($id)
    {
        $suratDetail = SuratDetail::findOrFail($id);
    
        if ($suratDetail->status == 'diproses') {
            $suratDetail->delete();
            return redirect()->back()->with('success', 'Surat telah berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Surat tidak dapat dihapus, status tidak sesuai.');
        }
    }
    
}
