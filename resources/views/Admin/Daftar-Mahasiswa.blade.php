@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-admin')
@endsection

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Daftar Mahasiswa</h2>
            <!-- Tombol Registrasi yang membuka modal -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registrasiModal">
                + Registrasi
            </button>
        </div>

        <form method="GET" action="{{ route('admin.daftar-mahasiswa') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="filter" class="form-control" placeholder="Cari berdasarkan NRP"
                    value="{{ request('filter') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>

        <table class="table table-hover text-center shadow-sm rounded" style="overflow: hidden; border-radius: 12px;">
            <thead style="background: linear-gradient(to right, #667eea, #764ba2); color: white;">
                <tr>
                    <th style="padding: 12px;">NRP</th>
                    <th style="padding: 12px;">Nama</th>
                    <th style="padding: 12px;">Program Studi</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $mhs)
                    <tr style="background-color: #f9f9fc;">
                        <td style="vertical-align: middle;">{{ $mhs->nrp }}</td>
                        <td style="vertical-align: middle;">{{ $mhs->user->nama }}</td>
                        <td style="vertical-align: middle;">
                            {{ $mhs->programStudi->nama_program_studi ?? 'Tidak Diketahui' }}
                        <td style="vertical-align: middle;">{{ $mhs->user->email }}</td>
                        <td style="vertical-align: middle;">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editMahasiswa{{ $mhs->nrp }}">
                                Edit
                            </button>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editMahasiswa{{ $mhs->nrp }}" tabindex="-1"
                                aria-labelledby="editMahasiswaLabel{{ $mhs->nrp }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.update-mahasiswa', $mhs->nrp) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #764ba2; color: white;">
                                                <h5 class="modal-title">Edit Mahasiswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $mhs->user->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $mhs->user->email }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Registrasi -->
        <div class="modal fade" id="registrasiModal" tabindex="-1" aria-labelledby="registrasiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.store-mahasiswa') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #764ba2; color: white;">
                            <h5 class="modal-title" id="registrasiModalLabel">Registrasi Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nrp" class="form-label">NRP</label>
                                <input type="text" name="nrp" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                                <small class="form-text text-muted">Password harus terdiri dari minimal 6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi_id" class="form-label">Program Studi</label>
                                <select name="program_studi_id" class="form-control" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($programStudi as $prodi)
                                        <option value="{{ $prodi->id_program_studi }}">{{ $prodi->nama_program_studi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Registrasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
