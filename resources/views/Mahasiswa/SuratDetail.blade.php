@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-mahasiswa')
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-body">
                <h4 class="card-title text-center text-primary">Daftar Surat Detail</h4>
                <p class="card-description text-center text-muted">
                    Data pengajuan surat dan statusnya
                </p>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <tr>
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
                            @foreach ($suratDetails as $detail)
                                <tr class="align-middle">
                                    <td>{{ $detail->nama_pengaju ?? '-' }}</td>
                                    <td>{{ $detail->jenis_surat_nama ?? '-' }}</td>
                                    <td>{{ $detail->tanggal_diajukan ? \Carbon\Carbon::parse($detail->tanggal_diajukan)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($detail->status == 'diproses')
                                            <span class="badge bg-warning text-dark">Diproses</span>
                                        @elseif ($detail->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($detail->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($detail->status == 'ditolak')
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#alasanModal{{ $detail->id }}">
                                                Lihat Alasan
                                            </button>


                                            <!-- Modal Versi Bootstrap 4 -->
                                            <div class="modal fade" id="alasanModal{{ $detail->id }}" tabindex="-1"
                                                aria-labelledby="alasanModalLabel{{ $detail->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="alasanModalLabel{{ $detail->id }}">Alasan
                                                                Penolakan</h5>
                                                            <button type="button" class="btn-close bg-white"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-dark">
                                                            {{ $detail->alasan_penolakan ?? 'Tidak ada alasan yang diberikan.' }}
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

                                    <td>{{ $detail->nama_kaprodi ?? '-' }}</td>
                                    <td>{{ $detail->nama_karyawan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
        }

        .table {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .badge {
            font-size: 1rem;
            padding: 8px 12px;
            border-radius: 8px;
        }

    </style>
@endsection
