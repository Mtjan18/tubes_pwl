@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-karyawan')
@endsection

@section('content')
    <div class="container">
        <h1 class="mb-4 text-black text-center">Dashboard Karyawan</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Filter Surat -->
        <form method="GET" action="{{ route('karyawan.dashboard') }}" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="jenis_surat" class="form-label text-black">Filter Jenis Surat:</label>
                    <select name="jenis_surat" class="form-control text-dark bg-white">
                        <option value="">Semua Jenis Surat</option>
                        @foreach ($jenisSurats as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <h3 class="text-black mt-4">Daftar Surat yang Masuk</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3" style="border-radius: 10px; overflow: hidden;">
                <thead class="text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Nama Mahasiswa</th>
                        <th>NRP</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Status</th>
                        <th>Lihat Surat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surats as $surat)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $surat->jenisSurat->nama_jenis ?? '-' }}</td>
                            <td>{{ $surat->nama ?? '-' }}</td>
                            <td>{{ $surat->mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $surat->created_at->format('d-m-Y') }}</td>
                            <td>
                                <span
                                    class="badge 
                                    @if ($surat->suratDetail->status == 'terima') bg-success 
                                    @elseif($surat->suratDetail->status == 'tolak') bg-danger 
                                    @else bg-warning @endif">
                                    {{ ucfirst($surat->suratDetail->status ?? 'Pending') }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                    data-bs-target="#modalLihatSurat{{ $surat->id }}">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                            </td>
                            <td>
                                <!-- Tombol Terima -->
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalTerima{{ $surat->id }}">
                                    <i class="fas fa-check-circle"></i> Terima
                                </button>

                                <!-- Tombol Tolak -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalTolak{{ $surat->id }}">
                                    <i class="fas fa-times-circle"></i> Tolak
                                </button>
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




                        <!-- Modal Terima -->
                        <div class="modal fade" id="modalTerima{{ $surat->id }}" tabindex="-1"
                            aria-labelledby="modalTerimaLabel{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('karyawan.validasiSurat', $surat->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="terima">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="modalTerimaLabel{{ $surat->id }}">Konfirmasi
                                                Terima Surat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin <strong>menerima</strong> surat ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Ya, Terima</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="modalTolak{{ $surat->id }}" tabindex="-1"
                            aria-labelledby="modalTolakLabel{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('karyawan.validasiSurat', $surat->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="tolak">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalTolakLabel{{ $surat->id }}">Tolak Surat
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="alasan{{ $surat->id }}" class="form-label">Alasan
                                                    Penolakan</label>
                                                <textarea class="form-control" id="alasan{{ $surat->id }}" name="alasan" rows="3" required>{{ $surat->suratDetail->alasan_penolakan ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Surat</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-white">Tidak ada surat ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .table {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            overflow: hidden;
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .badge {
            font-size: 1rem;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .btn {
            font-weight: bold;
            border-radius: 8px;
        }
    </style>
@endsection
