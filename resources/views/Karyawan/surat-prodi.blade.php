@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-karyawan')
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-body">
                <h4 class="card-title text-center text-primary">Surat Disetujui Kaprodi - Prodi
                    {{ $prodi->nama_program_studi }}</h4>
                <p class="card-description text-center text-muted">
                    Daftar surat yang telah disetujui oleh Kaprodi
                </p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="nrp" class="form-control" placeholder="Cari NRP"
                            value="{{ request('nrp') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="jenis_surat" class="form-select select2">
                            <option value="">-- Semua Jenis Surat --</option>
                            @foreach ($jenisSuratList as $jenis)
                                <option value="{{ $jenis->id }}"
                                    {{ request('jenis_surat') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-light">Filter</button>
                        <a href="{{ route('karyawan.byProdi', $prodi->id_program_studi) }}" class="btn btn-light">Reset</a>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Upload Surat PDF</th>
                                <th>PDF Terkirim</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratDisetujui as $detail)
                                <tr>
                                    <td>{{ $detail->surat->nama }}</td>
                                    <td>{{ $detail->surat->jenisSurat->nama_jenis }}</td>
                                    <td>
                                        <span
                                            class="badge badge-success text-uppercase px-3 py-2">{{ $detail->status }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('karyawan.upload', $detail->id) }}" method="POST"
                                            enctype="multipart/form-data" class="d-flex flex-column gap-2">
                                            @csrf
                                            <input type="file" name="file_pdf" accept="application/pdf"
                                                class="form-control form-control-sm mb-1" required>
                                            @if (!$detail->file_path)
                                                <button class="btn btn-sm btn-primary" type="submit">Upload</button>
                                            @else
                                                <button class="btn btn-sm btn-warning" type="submit">Ganti PDF</button>
                                            @endif
                                        </form>
                                    </td>

                                    <td>
                                        @if ($detail->file_path)
                                            <a href="{{ asset('storage/' . $detail->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-secondary">Lihat File</a>
                                        @else
                                            <span class="text-muted fst-italic">Belum tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada surat yang disetujui
                                        kaprodi.</td>
                                </tr>
                            @endforelse
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

        <style>.select2-container--classic .select2-selection--single {
            height: 38px;
            padding: 5px 10px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>

@endsection
