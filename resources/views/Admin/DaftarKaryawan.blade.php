@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-admin')
@endsection

@section('content')
<div class="container mt-3">
    <h2>Daftar Karyawan & Kaprodi</h2>

    <form method="GET" action="{{ route('admin.daftar-karyawan') }}" class="mb-3 row g-2">
        <div class="col-md-4">
            <input type="text" name="filter" class="form-control" placeholder="Cari berdasarkan nama" value="{{ request('filter') }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="karyawan" {{ request('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                <option value="kaprodi" {{ request('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawan as $kar)
            <tr>
                <td>{{ $kar->nip }}</td>
                <td>{{ $kar->user->nama }}</td>
                <td>{{ $kar->user->email }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editKaryawan{{ $kar->nip }}">Edit</button>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editKaryawan{{ $kar->nip }}" tabindex="-1" aria-labelledby="editKaryawanLabel{{ $kar->nip }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('admin.update-karyawan', $kar->nip) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Karyawan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $kar->user->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $kar->user->email }}" required>
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
