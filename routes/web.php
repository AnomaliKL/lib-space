<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Member\MemberController as MemberSpaceController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTE OTENTIKASI (GUEST - Hanya bisa diakses jika belum login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

// Rute logout bisa diakses kapan saja asal sudah login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// AREA PETUGAS ADMIN (Wajib Login & Status Aktif)
// ==========================================
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    // Rute Sirkulasi Pengembalian Buku
    Route::get('/pengembalian', [BorrowingController::class, 'returnIndex'])->name('admin.pengembalian.index');
    Route::patch('/pengembalian/{id}/proses', [BorrowingController::class, 'processReturn'])->name('admin.peminjaman.return');

    // Rute Katalog Master (Buku & Kategori)
    Route::get('/katalog', [BookController::class, 'index']);
    Route::post('/katalog', [BookController::class, 'store'])->name('admin.katalog.store');
    Route::put('/katalog/{id}', [BookController::class, 'update'])->name('admin.katalog.update');
    Route::delete('/katalog/{id}', [BookController::class, 'destroy'])->name('admin.katalog.destroy');
    Route::post('/katalog/kategori', [BookController::class, 'storeCategory'])->name('admin.kategori.store');

    // Rute Sirkulasi Peminjaman & Manajemen Booking Buku
    Route::get('/peminjaman', [BorrowingController::class, 'index']);
    Route::post('/peminjaman', [BorrowingController::class, 'store'])->name('admin.peminjaman.store');
    Route::patch('/peminjaman/booking/{id}/setuju', [BorrowingController::class, 'acceptBooking'])->name('admin.peminjaman.accept');
    Route::patch('/peminjaman/booking/{id}/ambil', [BorrowingController::class, 'takeBook'])->name('admin.peminjaman.ambil');
    Route::delete('/peminjaman/booking/{id}/tolak', [BorrowingController::class, 'rejectBooking'])->name('admin.peminjaman.reject');

    // Rute Anggota Master (Manajemen Data Anggota oleh Admin)
    Route::get('/anggota', [MemberController::class, 'index']);
    Route::post('/anggota', [MemberController::class, 'store'])->name('admin.anggota.store');
    Route::put('/anggota/{id}', [MemberController::class, 'update'])->name('admin.anggota.update');
    Route::delete('/anggota/{id}', [MemberController::class, 'destroy'])->name('admin.anggota.destroy');
    Route::patch('/anggota/{id}/toggle-status', [MemberController::class, 'toggleStatus'])->name('admin.anggota.toggle-status');
});

// ==========================================
// AREA ANGGOTA / MAHASISWA (Wajib Login)
// ==========================================
Route::prefix('member')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('member.dashboard');
    });

    Route::get('/dashboard', [MemberSpaceController::class, 'index'])->name('member.dashboard');
    Route::post('/booking', [MemberSpaceController::class, 'storeBooking'])->name('member.booking.store');
    Route::get('/riwayat', [MemberSpaceController::class, 'history'])->name('member.history');
});

// Redirect root website utama
Route::get('/', function () {
    return redirect()->route('login');
});
