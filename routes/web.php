<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MhsAktifController;
use App\Http\Controllers\LaporanStudiController;
use App\Http\Controllers\SuratPengantarTugasController;
use App\Http\Controllers\MhsLulusController;
use App\Http\Controllers\SuratDetailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('login');

// ========================
// AUTH ROUTES
// ========================
Route::prefix('login')->group(function () {
    Route::get('/mahasiswa', [LoginController::class, 'showMahasiswaLoginForm'])->name('login.mahasiswa');
    Route::post('/mahasiswa', [LoginController::class, 'mahasiswaLogin']);

    Route::get('/pegawai', [LoginController::class, 'showPegawaiLoginForm'])->name('login.pegawai');
    Route::post('/pegawai', [LoginController::class, 'pegawaiLogin']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================
// MAHASISWA ROUTES
// ========================
Route::middleware(['auth', 'student'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('DashboardMahasiswa');
    })->name('dashboard.mahasiswa');

    Route::get('/form-surat', function () {
        return view('mahasiswa.FormSurat');
    })->name('Mahasiswa.FormSurat');

    // Surat pengajuan
    Route::post('/surat/aktif/store', [MhsAktifController::class, 'store'])->name('surat.aktif.store');
    Route::post('/surat/laporan-studi/store', [LaporanStudiController::class, 'store'])->name('surat.laporan-studi.store');
    Route::post('/surat/pengantar-tugas/store', [SuratPengantarTugasController::class, 'store'])->name('surat.pengantar-tugas.store');
    Route::post('/surat/lulus/store', [MhsLulusController::class, 'store'])->name('surat.lulus.store');
    Route::resource('suratDetail', SuratDetailController::class);
});

// ========================
// KARYAWAN ROUTES
// ========================
Route::middleware(['auth', 'staff'])->prefix('karyawan')->group(function () {
    Route::get('/dashboard/karyawan', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
    Route::get('/{prodi}', [KaryawanController::class, 'byProdi'])->name('karyawan.byProdi');
    Route::post('/dashboard/karyawan/upload/{id}', [KaryawanController::class, 'upload'])->name('karyawan.upload');
    Route::redirect('/karyawan/dashboard/karyawan', '/karyawan/TI');
});


// ========================
// KAPRODI ROUTES
// ========================
Route::middleware(['auth', 'kaprodi'])->prefix('kaprodi')->group(function () {
    Route::get('/dashboard', [KaprodiController::class, 'index'])->name('kaprodi.dashboard');
    Route::post('/validasi-surat/{id}', [KaprodiController::class, 'validasiSurat'])->name('kaprodi.validasiSurat');
    
    Route::get('/daftar-surat', [KaprodiController::class, 'daftarSurat'])->name('kaprodi.daftarSurat');
});

// ========================
// ADMIN ROUTES
// ========================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Daftar Mahasiswa
    Route::get('/daftar-mahasiswa', [AdminController::class, 'daftarMahasiswa'])->name('admin.daftar-mahasiswa');
    Route::post('/store-mahasiswa', [AdminController::class, 'storeMahasiswa'])->name('admin.store-mahasiswa');
    Route::put('/update-mahasiswa/{nrp}', [AdminController::class, 'updateMahasiswa'])->name('admin.update-mahasiswa');

    // Daftar Karyawan & Kaprodi
    Route::get('/daftar-karyawan', [AdminController::class, 'daftarKaryawan'])->name('admin.daftar-karyawan');
    Route::post('/store-karyawan', [AdminController::class, 'storeKaryawan'])->name('admin.store-karyawan');
    Route::put('/update-karyawan/{nip}', [AdminController::class, 'updateKaryawan'])->name('admin.update-karyawan');

    // Halaman gabungan mahasiswa dan karyawan (jika ada fitur tersebut)
    Route::get('/daftar-mahasiswa-karyawan', [AdminController::class, 'showMahasiswaKaryawan'])->name('admin.daftar-mahasiswa-karyawan');
});





// ========================
// SURAT DETAIL & SETTINGS
// ========================
Route::middleware(['auth'])->group(function () {
    Route::get('/surat-detail', [SuratDetailController::class, 'index'])->name('surat.detail');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
});

// ========================
// OPTIONAL: Tambahan Dashboard Umum
// ========================
Route::middleware(['auth'])->group(function () {
    Route::get('/index', function () {
        return view('index');
    });

    Route::get('/index_mahasiswa', function () {
        return view('index_mahasiswa');
    });
});
