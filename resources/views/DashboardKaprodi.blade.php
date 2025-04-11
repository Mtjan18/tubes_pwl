@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-kaprodi')
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4 text-black text-center">Daftar Surat yang Sudah Diproses</h1>

        <!-- Filter -->
        <form method="GET" action="{{ route('kaprodi.dashboard') }}" class="mb-4">
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
        <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered table-hover mt-3" style="min-width: 1200px;"> {{-- Perlebar tabel --}}
                <thead class="text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NRP</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Alasan Penolakan</th>
                        <th>Disetujui Oleh</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($surats as $surat)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $surat->nama ?? '-' }}</td>
                            <td>{{ $surat->mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $surat->jenisSurat->nama_jenis ?? '-' }}</td>
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
                                        Diproses
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
                                                    {{ $surat->suratDetail->alasan_penolakan ?? 'Tidak ada alasan.' }}
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
                            <td>
                                @if ($surat->suratDetail->status != 'diproses')
                                    {{ $surat->suratDetail->approved_by ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                    data-bs-target="#modalLihatSurat{{ $surat->id }}">
                                    Lihat
                                </button>
                            </td>

                            <td>
                                @if ($surat->suratDetail->status == 'diproses')
                                    <form method="POST" action="{{ route('kaprodi.validasiSurat', $surat->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="status" value="terima"
                                            class="btn btn-success btn-sm">Setujui</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tolakModal{{ $surat->id }}">Tolak</button>
                                    </form>

                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="tolakModal{{ $surat->id }}" tabindex="-1"
                                        aria-labelledby="tolakModalLabel{{ $surat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('kaprodi.validasiSurat', $surat->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="ditolak">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="tolakModalLabel{{ $surat->id }}">
                                                            Alasan Penolakan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea name="alasan_penolakan" class="form-control" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Kirim
                                                            Penolakan</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Sudah divalidasi</span>
                                @endif
                            </td>
                        </tr>
                        <!-- Modal Lihat Surat -->
                        <div class="modal fade" id="modalLihatSurat{{ $surat->id }}" tabindex="-1"
                            aria-labelledby="modalLihatLabel{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalLihatLabel{{ $surat->id }}">Detail Surat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-black">
                                        @if ($surat->jenis_surat_id == 1)
                                            <p><strong>Nama:</strong> {{ $surat->nama }}</p>
                                            <p><strong>NRP:</strong> {{ $surat->mahasiswa->nrp ?? '-' }}</p>
                                            <p><strong>Semester:</strong> {{ $surat->semester }}</p>
                                            <p><strong>Keperluan:</strong> {{ $surat->keperluan }}</p>
                                        @elseif ($surat->jenis_surat_id == 2)
                                            <p><strong>Nama:</strong> {{ $surat->nama }}</p>
                                            <p><strong>NRP:</strong> {{ $surat->mahasiswa->nrp ?? '-' }}</p>
                                            <p><strong>Ditujukan ke:</strong> {{ $surat->ditujukan_ke }}</p>
                                            <p><strong>Nama Matkul:</strong> {{ $surat->nama_matkul }}</p>
                                            <p><strong>Semester:</strong> {{ $surat->semester }}</p>
                                            <p><strong>Data Mahasiswa:</strong> {{ $surat->data_mahasiswa }}</p>
                                            <p><strong>Topik:</strong> {{ $surat->topik }}</p>
                                            <p><strong>Tujuan Topik:</strong> {{ $surat->tujuan_topik }}</p>
                                        @elseif ($surat->jenis_surat_id == 3)
                                            <p><strong>Nama:</strong> {{ $surat->nama }}</p>
                                            <p><strong>NRP:</strong> {{ $surat->mahasiswa->nrp ?? '-' }}</p>
                                            <p><strong>Tanggal Lulus:</strong> {{ $surat->tgl_lulus }}</p>
                                        @elseif ($surat->jenis_surat_id == 4)
                                            <p><strong>Nama:</strong> {{ $surat->nama }}</p>
                                            <p><strong>NRP:</strong> {{ $surat->mahasiswa->nrp ?? '-' }}</p>
                                            <p><strong>Keperluan:</strong> {{ $surat->keperluan }}</p>
                                        @else
                                            <p>Data surat tidak dikenali.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-black">Tidak ada surat yang sudah diproses.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
