<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SuratDetail;
use App\Models\Notification;

class KaprodiController extends Controller
{
    public function index(Request $request)
    {
        $jenisSurats = JenisSurat::all();

        $user = Auth::user();
        $programStudiKaprodi = $user->karyawan->program_studi_id;

        $query = Surat::with(['mahasiswa', 'jenisSurat', 'suratDetail'])
            ->whereHas('suratDetail', function ($q) {
                $q->where('status', 'diproses');
            })
            ->whereHas('mahasiswa', function ($q) use ($programStudiKaprodi) {
                $q->where('program_studi_id', $programStudiKaprodi);
            });

        // filter tambahan
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

        $unreadNotifications = Notification::where('is_read', false)->count();
        return view('DashboardKaprodi', compact('surats', 'jenisSurats', 'unreadNotifications'));
    }




    public function validasiSurat(Request $request, $id)
    {
        Notification::where('surat_id', $id)->update(['is_read' => true]);

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
        $user = Auth::user();
        $programStudiKaprodi = $user->karyawan->program_studi_id;

        $surats = Surat::with(['jenisSurat', 'mahasiswa', 'suratDetail.kaprodi'])
            ->whereHas('suratDetail', function ($query) {
                $query->whereIn('status', ['disetujui', 'ditolak']);
            })
            ->whereHas('mahasiswa', function ($q) use ($programStudiKaprodi) {
                $q->where('program_studi_id', $programStudiKaprodi);
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
