@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-karyawan')
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Surat Disetujui Kaprodi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Jenis Surat</th>
                <th>Keperluan</th>
                <th>Status</th>
                <th>Upload Surat PDF</th>
                <th>PDF Terkirim</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suratDisetujui as $detail)
                <tr>
                    <td>{{ $detail->surat->nama }}</td>
                    <td>{{ $detail->surat->jenisSurat->nama_jenis }}</td>
                    <td>{{ $detail->surat->keperluan ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ $detail->status }}</span></td>
                    <td>
                        @if(!$detail->file_path)
                            <form action="{{ route('karyawan.upload', $detail->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_pdf" accept="application/pdf" class="form-control mb-2" required>
                                <button class="btn btn-sm btn-primary" type="submit">Upload</button>
                            </form>
                        @else
                            <em>Sudah dikirim</em>
                        @endif
                    </td>
                    <td>
                        @if($detail->file_path)
                            <a href="{{ asset('storage/'.$detail->file_path) }}" target="_blank" class="btn btn-sm btn-secondary">Lihat File</a>
                        @else
                            <span class="text-muted">Belum tersedia</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
