<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SuratDetail;

class KaprodiController extends Controller
{
    public function index(Request $request)
    {
        $jenisSurats = JenisSurat::all();

        $query = Surat::with(['mahasiswa', 'jenisSurat', 'suratDetail'])
            ->whereHas('suratDetail', function ($q) {
                $q->where('status', 'diproses'); 
            });

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat_id', $request->jenis_surat);
        }

        if ($request->filled('status')) {
            $query->whereHas('suratDetail', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('nrp')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nrp', 'like', '%' . $request->nrp . '%');
            });
        }

        $surats = $query->get();

        return view('DashboardKaprodi', compact('surats', 'jenisSurats'));
    }



    public function validasiSurat(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terima,tolak',
            'alasan' => 'nullable|string|max:255'
        ]);

        $suratDetail = SuratDetail::where('surat_id', $id)->first();

        if (!$suratDetail) {
            return redirect()->route('kaprodi.dashboard')->with('status', 'Data surat tidak ditemukan.');
        }

        $suratDetail->status = $request->status === 'tolak' ? 'ditolak' : 'disetujui';
        $suratDetail->approved_by = Auth::id(); // user_id kaprodi

        if ($request->status === 'tolak') {
            $suratDetail->alasan_penolakan = $request->alasan ?? 'Tidak ada alasan yang diberikan';
        } else {
            $suratDetail->alasan_penolakan = null;
        }

        $suratDetail->save();

        return redirect()->route('kaprodi.dashboard')->with('status', 'Surat berhasil divalidasi.');
    }

    public function daftarSurat(Request $request)
    {
        $surats = Surat::with(['jenisSurat', 'mahasiswa', 'suratDetail'])
            ->whereHas('suratDetail', function ($query) {
                $query->whereIn('status', ['disetujui', 'ditolak']);
            })
            ->when($request->jenis_surat, function ($query) use ($request) {
                $query->where('jenis_surat_id', $request->jenis_surat);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->whereHas('suratDetail', function ($q) use ($request) {
                    $q->where('status', $request->status);
                });
            })
            ->when($request->nrp, function ($query) use ($request) {
                $query->whereHas('mahasiswa', function ($q) use ($request) {
                    $q->where('nrp', 'like', '%' . $request->nrp . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $jenisSurats = JenisSurat::all();

        return view('kaprodi.DaftarSurat', compact('surats', 'jenisSurats'));
    }
}
