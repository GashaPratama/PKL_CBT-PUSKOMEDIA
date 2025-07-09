<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\SoalImportController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\UjianController;

// =======================
// ROUTE UTAMA / PUBLIK
// =======================
Route::get('/', fn () => view('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register']);
Route::view('/registrasi', 'registrasi akun');

// =======================
// ROUTE YANG BUTUH LOGIN
// =======================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===================
    // ADMIN
    // ===================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Ujian
        Route::get('/ujian/create', [ExamController::class, 'create'])->name('ujian.create');
        Route::post('/ujian/store', [ExamController::class, 'store'])->name('ujian.store');
        Route::get('/ujian/{id}/edit', [ExamController::class, 'edit'])->name('ujian.edit');
        Route::put('/ujian/{id}', [ExamController::class, 'update'])->name('ujian.update');
        Route::delete('/ujian/{id}', [ExamController::class, 'destroy'])->name('ujian.destroy');
        Route::get('/ujian/{id}', [ExamController::class, 'show'])->name('ujian.detail');
        Route::get('/ujian/{id}/nilai', [ExamController::class, 'nilai'])->name('nilai.show');

        // Export Nilai
        Route::get('/ujian/{id}/unduh-excel', [ExportController::class, 'exportExcel'])->name('ujian.export.excel');
        Route::get('/ujian/{id}/unduh-pdf', [ExportController::class, 'exportPdf'])->name('ujian.export.pdf');

        // Simulasi Ujian (Admin Preview)
        Route::get('/ujian/{id}/simulasi', [ExamController::class, 'simulasi'])->name('ujian.simulasi');
        Route::post('/ujian/{id}/simulasi/submit', [ExamController::class, 'submitSimulasi'])->name('ujian.simulasi.submit');

        // Peserta (User)
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

    // ===================
    // SISWA / PESERTA
    // ===================
    Route::middleware(['auth', 'role:siswa'])->group(function () {
        // Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');
        // Route::get('/ujian/{id}', [UjianController::class, 'index'])->name('ujian');
        Route::get('/siswa/dashboard', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard');
        Route::get('/siswa/ujian/{id}', [App\Http\Controllers\Siswa\UjianController::class, 'index'])->name('siswa.ujian');
        // Nanti bisa ditambah: download soal, submit jawaban, simpan localStorage, dll.
    });

    // Route::get('/siswa/dashboard', function () {
    // return 'Halo Siswa!';
    // })->middleware(['auth', 'role:siswa']);

});
