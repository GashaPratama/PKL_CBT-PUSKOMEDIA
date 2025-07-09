<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\SoalImportController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\UjianController;
use App\Http\Controllers\Api\SoalDownloadController;

// =======================
// ROUTE PUBLIK
// =======================
Route::get('/', fn () => view('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register']);
Route::view('/registrasi', 'registrasi akun');

// =======================
// ROUTE SISWA
// =======================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');
    Route::get('/ujian/{id}', [UjianController::class, 'index'])->name('ujian');
    // Bisa ditambah: download soal, submit jawaban, simpan localStorage
});

// =======================
// ROUTE SISWA PREFIX API
// =======================
Route::middleware(['auth', 'role:siswa'])->prefix('api')->group(function () {
    Route::get('/ujian/{id}/soal', [SoalDownloadController::class, 'getSoal']);
});

// =======================
// ROUTE ADMIN
// =======================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Ujian
    Route::get('/ujian/create', [ExamController::class, 'create'])->name('ujian.create');
    Route::post('/ujian/store', [ExamController::class, 'store'])->name('ujian.store');
    Route::get('/ujian/{id}/edit', [ExamController::class, 'edit'])->name('ujian.edit');
    Route::put('/ujian/{id}', [ExamController::class, 'update'])->name('ujian.update');
    Route::delete('/ujian/{id}', [ExamController::class, 'destroy'])->name('ujian.destroy');
    Route::get('/ujian/{id}', [ExamController::class, 'show'])->name('ujian.detail');
    Route::get('/ujian/{id}/nilai', [ExamController::class, 'nilai'])->name('nilai.show');

    // Export
    Route::get('/ujian/{id}/unduh-excel', [ExportController::class, 'exportExcel'])->name('ujian.export.excel');
    Route::get('/ujian/{id}/unduh-pdf', [ExportController::class, 'exportPdf'])->name('ujian.export.pdf');

    // Simulasi Admin
    Route::get('/ujian/{id}/simulasi', [ExamController::class, 'simulasi'])->name('ujian.simulasi');
    Route::post('/ujian/{id}/simulasi/submit', [ExamController::class, 'submitSimulasi'])->name('ujian.simulasi.submit');

    // Manajemen Peserta
    Route::get('/user', [UserController::class, 'index'])->name('user.show');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::post('/user/reset/{id}', [UserController::class, 'resetPassword'])->name('user.reset');
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/export/excel', [UserController::class, 'exportExcel'])->name('user.export.excel');
    Route::get('/user/export/pdf', [UserController::class, 'exportPdf'])->name('user.export.pdf');

    // Soal
    Route::post('/soal/store', [SoalController::class, 'store'])->name('soal.store');
    Route::post('/soal/import', [SoalImportController::class, 'import'])->name('soal.import');
    Route::post('/soal/bulk-delete', [SoalController::class, 'bulkDelete'])->name('soal.bulkDelete');
});

// =======================
// LOGOUT (umum)
// =======================
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');
