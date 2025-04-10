@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Profil Pengguna</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $data['profile_image'] }}" class="rounded-circle mb-3" width="100" height="100" alt="Profile Image">

                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $data['nama'] }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $data['email'] }}</td>
                        </tr>

                        @if($role === 'mahasiswa')
                            <tr>
                                <th>NRP</th>
                                <td>{{ $data['nrp'] }}</td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>{{ $data['program_studi'] }}</td>
                            </tr>
                        @elseif($role === 'karyawan' || $role === 'ketua_prodi')
                            <tr>
                                <th>NIP</th>
                                <td>{{ $data['nip'] }}</td>
                            </tr>
                            @if($role === 'ketua_prodi')
                                <tr>
                                    <th>Program Studi</th>
                                    <td>{{ $data['program_studi'] }}</td>
                                </tr>
                            @endif
                        @endif

                        <tr>
                            <th>Dibuat pada</th>
                            <td>{{ $data['dibuat_pada'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
