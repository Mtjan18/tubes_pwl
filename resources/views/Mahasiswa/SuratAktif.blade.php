@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengajuan Surat Keterangan Mahasiswa Aktif</h4>
                <p class="card-description">Silakan isi formulir berikut untuk mengajukan surat</p>

                <!-- Tampilkan pesan sukses -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="forms-sample" action="{{ route('surat.aktif.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" id="semester" name="semester">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required>
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" rows="4" placeholder="Jelaskan keperluan surat" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
