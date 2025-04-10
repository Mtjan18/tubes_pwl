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
Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
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
});

// ========================
// KARYAWAN ROUTES
// ========================
Route::middleware(['auth'])->prefix('karyawan')->group(function () {
    Route::get('/dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
    Route::post('/validasi-surat/{id}', [KaryawanController::class, 'validasiSurat'])->name('karyawan.validasiSurat');
    Route::get('/daftar-surat', [KaryawanController::class, 'daftarSurat'])->name('karyawan.daftarSurat');
});

// ========================
// KAPRODI ROUTES
// ========================
Route::middleware(['auth'])->prefix('kaprodi')->group(function () {
    Route::get('/dashboard', [KaprodiController::class, 'index'])->name('kaprodi.dashboard');
    Route::post('/validasi-surat/{id}', [KaprodiController::class, 'validasiSurat'])->name('kaprodi.validasiSurat');
    Route::get('/daftar-surat', [KaprodiController::class, 'daftarSurat'])->name('kaprodi.daftarSurat');
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
