<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - BI Kantin Web
|--------------------------------------------------------------------------
*/

// Rute Halaman Login & Autentikasi
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Khusus Admin (Diproteksi Middleware Role: Admin)
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // CRUD Menu
    Route::post('/menu', [AdminController::class, 'storeMenu'])->name('menu.store');
    Route::put('/menu/{id}', [AdminController::class, 'updateMenu'])->name('menu.update');
    Route::delete('/menu/{id}', [AdminController::class, 'destroyMenu'])->name('menu.destroy');
    
    // Kelola Status Pesanan
    Route::post('/pesanan/{id}/status', [AdminController::class, 'updateStatusPesanan'])->name('pesanan.status');
});

// Rute Khusus Siswa (Diproteksi Middleware Role: Siswa)
Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');
    Route::post('/pesan', [SiswaController::class, 'pesan'])->name('pesan');
    Route::get('/status-realtime', [SiswaController::class, 'statusRealtime'])->name('status.realtime');
});
