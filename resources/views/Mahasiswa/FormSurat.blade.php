@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar-mahasiswa')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-3">
                <div class="dropdown">
                    <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuSizeButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Form Surat Pengajuan
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton1">
                        <a class="dropdown-item py-3 toggle-form" href="#" id="showSuratAktif">Surat Keterangan
                            Mahasiswa
                            Aktif</a>
                        <a class="dropdown-item py-3 toggle-form" href="#" id="showSuratPengantarTugas">Surat
                            Pengantar Tugas Kuliah</a>
                        <a class="dropdown-item py-3 toggle-form" href="#" id="showSuratLulus">Surat Keterangan Lulus</a>
                        <a class="dropdown-item py-3 toggle-form" href="#" id="showSuratLaporanStudi">Laporan Hasil
                            Studi</a>
                    </div>
                </div>
            </div>

            {{-- 🔹 Form Surat Keterangan Mahasiswa Aktif (Disembunyikan Awal) --}}
            <div class="mt-4 form-container" id="formSuratAktif" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Surat Keterangan Mahasiswa Aktif</h4>
                        <form action="{{ route('surat.aktif.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ Auth::user()->nama ?? old('nama') }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nrp">NRP</label>
                                <input type="text" class="form-control" id="nrp" name="nrp"
                                    value="{{ Auth::user()->mahasiswa->nrp }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="text" class="form-control" id="semester" name="semester"
                                    placeholder="Masukkan Semester" required>
                                <small class="form-text text-muted">Format: semester_tahun (contoh: 4_2024/2025)</small>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan Alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="keperluan">Keperluan</label>
                                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" placeholder="Masukkan Keperluan"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- 🔹 Form Surat Laporan Hasil Studi (Disembunyikan Awal) --}}
            <div class="mt-4 form-container" id="formSuratLaporanStudi" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Surat Laporan Hasil Studi</h4>
                        <form action="{{ route('surat.laporan-studi.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ Auth::user()->nama ?? old('nama') }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nrp">NRP</label>
                                <input type="text" class="form-control" id="nrp" name="nrp"
                                    value="{{ Auth::user()->mahasiswa->nrp }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="keperluan">Keperluan</label>
                                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" placeholder="Masukkan Keperluan"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- 🔹 Form Surat Pengantar Tugas Kuliah (Disembunyikan Awal) --}}
            <div class="mt-4 form-container" id="formSuratPengantarTugas" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Surat Pengantar Tugas Kuliah</h4>
                        <form action="{{ route('surat.pengantar-tugas.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ Auth::user()->nama ?? old('nama') }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nrp">NRP</label>
                                <input type="text" class="form-control" id="nrp" name="nrp"
                                    value="{{ Auth::user()->mahasiswa->nrp }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="ditujukan_ke">Ditujukan Ke</label>
                                <input type="text" class="form-control" id="ditujukan_ke" name="ditujukan_ke"
                                    placeholder="Masukkan nama penerima surat" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_matkul">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="nama_matkul" name="nama_matkul"
                                    placeholder="Masukkan nama mata kuliah" required>
                            </div>
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="text" class="form-control" id="semester" name="semester"
                                    placeholder="Masukkan Semester" required>
                                <small class="form-text text-muted">Format: semester_tahun (contoh: 4_2024/2025)</small>
                            </div>
                            <div class="form-group">
                                <label for="data_mahasiswa">Data Mahasiswa</label>
                                <textarea class="form-control" id="data_mahasiswa" name="data_mahasiswa" rows="2"
                                    placeholder="Nama1-NRP, Nama2-NRP, ..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="topik">Topik</label>
                                <textarea class="form-control" id="topik" name="topik" rows="2" placeholder="Masukkan Topik"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tujuan_topik">Tujuan Topik</label>
                                <textarea class="form-control" id="tujuan_topik" name="tujuan_topik" rows="2"
                                    placeholder="Masukkan Tujuan Topik"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- 🔹 Form Surat Keterangan Lulus (Disembunyikan Awal) --}}
            <div class="mt-4 form-container" id="formSuratLulus" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Surat Keterangan Lulus</h4>
                        <form action="{{ route('surat.lulus.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ Auth::user()->nama ?? old('nama') }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nrp">NRP</label>
                                <input type="text" class="form-control" id="nrp" name="nrp"
                                    value="{{ Auth::user()->mahasiswa->nrp }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lulus">Tanggal Lulus</label>
                                <input type="date" class="form-control" id="tgl_lulus" name="tgl_lulus" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Script jQuery untuk Menampilkan Form --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function hideAllForms() {
                $(".form-container").slideUp();
            }
    
            $("#showSuratAktif").click(function (e) {
                e.preventDefault();
                hideAllForms();
                $("#formSuratAktif").slideDown();
            });
    
            $("#showSuratLaporanStudi").click(function (e) {
                e.preventDefault();
                hideAllForms();
                $("#formSuratLaporanStudi").slideDown();
            });
    
            $("#showSuratPengantarTugas").click(function (e) {
                e.preventDefault();
                hideAllForms();
                $("#formSuratPengantarTugas").slideDown();
            });
    
            $("#showSuratLulus").click(function (e) {
                e.preventDefault();
                hideAllForms();
                $("#formSuratLulus").slideDown();
            });
        });
    </script>    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
@endsection
