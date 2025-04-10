@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-kaprodi')
@endsection

@section('content')
    <div class="container">
        <h1 class="mb-4 text-black text-center">Daftar Surat yang Sudah Diproses</h1>

        <!-- Filter -->
        <form method="GET" action="{{ route('kaprodi.daftarSurat') }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-black">Jenis Surat:</label>
                    <select name="jenis_surat" class="form-control text-dark bg-white">
                        <option value="">Semua</option>
                        @foreach ($jenisSurats as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ request('jenis_surat') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-black">Status:</label>
                    <select name="status" class="form-control text-dark bg-white">
                        <option value="">Semua</option>
                        <option value="terima" {{ request('status') == 'terima' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-black">NRP:</label>
                    <input type="text" name="nrp" class="form-control text-dark bg-white" placeholder="Masukkan NRP"
                        value="{{ request('nrp') }}">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-warning fw-bold">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <!-- Tabel Surat -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Alasan Penolakan</th>
                        <th>Disetujui Oleh</th>
                        <th>Diproses Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($surats as $surat)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $surat->jenisSurat->nama_jenis ?? '-' }}</td>
                            <td>{{ $surat->nama }}</td>
                            <td>{{ $surat->mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $surat->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span
                                    class="badge
                                @if ($surat->suratDetail->status == 'terima') bg-success 
                                @elseif($surat->suratDetail->status == 'ditolak') bg-danger 
                                @else bg-secondary @endif">
                                    @if ($surat->suratDetail->status == 'terima')
                                        Disetujui
                                    @elseif ($surat->suratDetail->status == 'ditolak')
                                        Ditolak
                                    @else
                                        -
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if ($surat->suratDetail->status == 'ditolak')
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#alasanModal{{ $surat->id }}">
                                        Lihat Alasan
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="alasanModal{{ $surat->id }}" tabindex="-1"
                                        aria-labelledby="alasanModalLabel{{ $surat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="alasanModalLabel{{ $surat->id }}">Alasan
                                                        Penolakan</h5>
                                                    <button type="button" class="btn-close bg-white"
                                                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-dark">
                                                    {{ $surat->suratDetail->alasan_penolakan ?? 'Tidak ada alasan yang diberikan.' }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-white">Tidak ada surat yang sudah diproses.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
