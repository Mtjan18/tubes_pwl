<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route login mahasiswa
Route::get('/login/mahasiswa', [LoginController::class, 'showMahasiswaLoginForm'])->name('login.mahasiswa');
Route::post('/login/mahasiswa', [LoginController::class, 'mahasiswaLogin'])->name('login.mahasiswa');

// Route login pegawai
Route::get('/login/pegawai', [LoginController::class, 'showPegawaiLoginForm'])->name('login.pegawai');
Route::post('/login/pegawai', [LoginController::class, 'pegawaiLogin'])->name('login.pegawai');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard setelah login
Route::get('/index_mahasiswa', function () {
    return view('index_mahasiswa');
})->middleware('auth');

Route::get('/index', function () {
    return view('index');
})->middleware('auth');
