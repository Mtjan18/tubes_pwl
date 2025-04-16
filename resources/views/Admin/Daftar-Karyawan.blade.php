@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-admin')
@endsection

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Daftar Karyawan & Kaprodi</h2>
            <!-- Tombol Registrasi yang membuka modal -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registrasiModal">
                + Registrasi
            </button>
        </div>

        <form method="GET" action="{{ route('admin.daftar-karyawan') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="filter" class="form-control" placeholder="Cari berdasarkan nama"
                    value="{{ request('filter') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select text-white"
                    style="background: linear-gradient(to right, #667eea, #764ba2); border: none;">
                    <option value="">Semua Role</option>
                    <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="kaprodi" {{ request('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>

        <table class="table table-hover text-center shadow-sm rounded" style="overflow: hidden; border-radius: 12px;">
            <thead style="background: linear-gradient(to right, #667eea, #764ba2); color: white;">
                <tr>
                    <th style="padding: 12px;">NIP</th>
                    <th style="padding: 12px;">Nama</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Jabatan</th>
                    <th style="padding: 12px;">Program Studi</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($karyawan as $kar)
                    <tr style="background-color: #f9f9fc;">
                        <td style="vertical-align: middle;">{{ $kar->nip }}</td>
                        <td style="vertical-align: middle;">{{ $kar->user->nama }}</td>
                        <td style="vertical-align: middle;">{{ $kar->user->email }}</td>
                        <td style="vertical-align: middle;">
                            {{ $kar->user->role_id == 3 ? 'Kaprodi' : 'Karyawan' }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $kar->programStudi->nama_program_studi ?? '-' }}
                        </td>

                        <td style="vertical-align: middle;">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editKaryawan{{ $kar->nip }}">
                                Edit
                            </button>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editKaryawan{{ $kar->nip }}" tabindex="-1"
                                aria-labelledby="editKaryawanLabel{{ $kar->nip }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.update-karyawan', $kar->nip) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #764ba2; color: white;">
                                                <h5 class="modal-title">Edit Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- NIP -->
                                                <div class="mb-3">
                                                    <label for="nip" class="form-label">NIP</label>
                                                    <input type="text" name="nip" class="form-control"
                                                        value="{{ $kar->nip }}" required>
                                                </div>
                                                <!-- Nama -->
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $kar->user->nama }}" required>
                                                </div>
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $kar->user->email }}" required>
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
                <form method="POST" action="{{ route('admin.store-karyawan') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #764ba2; color: white;">
                            <h5 class="modal-title" id="registrasiModalLabel">Registrasi Karyawan / Kaprodi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" required>
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
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="karyawan">Karyawan</option>
                                    <option value="kaprodi">Kaprodi</option>
                                </select>
                            </div>
                            <div class="mb-3" id="programStudiGroup">
                                <label for="program_studi_id" class="form-label">Program Studi</label>
                                <select name="program_studi_id" id="program_studi_id" class="form-select">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <option value="-">-</option>
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
