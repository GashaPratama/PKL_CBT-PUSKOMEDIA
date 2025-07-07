<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\SoalImportController;

Route::get('/', function () {
    return view('login');
});

// Route bebas akses
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register']);
Route::view('/registrasi', 'registrasi akun');

// Route yang harus login
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/ujian/create', [ExamController::class, 'create'])->name('admin.ujian.create');
    Route::post('/admin/ujian/store', [ExamController::class, 'store'])->name('admin.ujian.store');
    Route::get('/admin/ujian/{id}/edit', [ExamController::class, 'edit'])->name('admin.ujian.edit');
    Route::put('/admin/ujian/{id}', [ExamController::class, 'update'])->name('admin.ujian.update');
    Route::delete('/admin/ujian/{id}', [ExamController::class, 'destroy'])->name('admin.ujian.destroy');
    Route::get('/admin/ujian/{id}', [ExamController::class, 'show'])->name('admin.ujian.detail');

    Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.show');

    Route::post('/admin/soal/store', [SoalController::class, 'store'])->name('admin.soal.store');
    Route::post('/admin/soal/import', [SoalImportController::class, 'import'])->name('admin.soal.import');

    Route::post('/admin/user/import', [UserController::class, 'import'])->name('admin.user.import');
    Route::post('/admin/user/reset/{id}', [UserController::class, 'resetPassword'])->name('admin.user.reset');
    Route::delete('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    


    
});