<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    // Rute Dashboard Utama
    Route::get('/', [DashboardController::class, 'index']);

    // Rute Sirkulasi Pengembalian Buku
    Route::get('/pengembalian', [BorrowingController::class, 'returnIndex'])->name('admin.pengembalian.index');
    Route::patch('/pengembalian/{id}/proses', [BorrowingController::class, 'processReturn'])->name('admin.peminjaman.return');

    // Rute Katalog Master (Buku & Kategori)
    Route::get('/katalog', [BookController::class, 'index']);
    Route::post('/katalog', [BookController::class, 'store'])->name('admin.katalog.store');
    Route::put('/katalog/{id}', [BookController::class, 'update'])->name('admin.katalog.update');
    Route::delete('/katalog/{id}', [BookController::class, 'destroy'])->name('admin.katalog.destroy');
    Route::post('/katalog/kategori', [BookController::class, 'storeCategory'])->name('admin.kategori.store'); // Diperbaiki prefix ganda /admin-nya

    // Rute Sirkulasi Peminjaman & Manajemen Booking Buku
    Route::get('/peminjaman', [BorrowingController::class, 'index']);
    Route::post('/peminjaman', [BorrowingController::class, 'store'])->name('admin.peminjaman.store');
    Route::patch('/peminjaman/booking/{id}/setuju', [BorrowingController::class, 'acceptBooking'])->name('admin.peminjaman.accept');
    Route::delete('/peminjaman/booking/{id}/tolak', [BorrowingController::class, 'rejectBooking'])->name('admin.peminjaman.reject');

    // Rute Anggota Master (Anggota LibSpace)
    Route::get('/anggota', [MemberController::class, 'index']);
    Route::post('/anggota', [MemberController::class, 'store'])->name('admin.anggota.store');
    Route::put('/anggota/{id}', [MemberController::class, 'update'])->name('admin.anggota.update');
    Route::delete('/anggota/{id}', [MemberController::class, 'destroy'])->name('admin.anggota.destroy');

    // 🔥 NEW ROUTE: Aksi mengubah status aktif/non-aktif secara dinamis via patch
    Route::patch('/anggota/{id}/toggle-status', [MemberController::class, 'toggleStatus'])->name('admin.anggota.toggle-status');

});

Route::get('/', function () {
    return redirect('/admin');
});
