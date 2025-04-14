@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-admin')
@endsection

@section('content')
<div class="container mt-3">
    <h2>Daftar Mahasiswa</h2>

    <form method="GET" action="{{ route('admin.daftar-mahasiswa') }}" class="mb-3">
        <input type="text" name="filter" class="form-control" placeholder="Cari berdasarkan nama" value="{{ request('filter') }}">
        <button type="submit" class="btn btn-primary mt-2">Cari</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NRP</th> <!-- Tambahkan kolom NRP di sini -->
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswa as $mhs)
            <tr>
                <td>{{ $mhs->nrp }}</td> <!-- Tambahkan data NRP di sini -->
                <td>{{ $mhs->user->nama }}</td>
                <td>{{ $mhs->user->email }}</td>
                <td>{{ $mhs->programStudi->nama_program_studi }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editMahasiswa{{ $mhs->nrp }}">Edit</button>
    
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editMahasiswa{{ $mhs->nrp }}" tabindex="-1" aria-labelledby="editMahasiswaLabel{{ $mhs->nrp }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('admin.update-mahasiswa', $mhs->nrp) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMahasiswaLabel{{ $mhs->nrp }}">Edit Mahasiswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control" value="{{ $mhs->user->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ $mhs->user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="program_studi_id" class="form-label">Program Studi</label>
                                            <select name="program_studi_id" id="program_studi_id" class="form-control" required>
                                                @foreach ($programStudi as $program)
                                                    <option value="{{ $program->id_program_studi }}" {{ $program->id_program_studi == $mhs->program_studi_id ? 'selected' : '' }}>
                                                        {{ $program->nama_program_studi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
    
</div>
@endsection
