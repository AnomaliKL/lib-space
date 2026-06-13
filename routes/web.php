<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route; // Import Controller Sirkulasi

Route::prefix('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    // GANTI BAGIAN PENGEMBALIAN MENJADI INI
    Route::get('/pengembalian', [BorrowingController::class, 'returnIndex'])->name('admin.pengembalian.index');
    Route::patch('/pengembalian/{id}/proses', [BorrowingController::class, 'processReturn'])->name('admin.peminjaman.return');

    // Rute Katalog Master
    Route::get('/katalog', [BookController::class, 'index']);
    Route::post('/katalog', [BookController::class, 'store'])->name('admin.katalog.store');
    Route::put('/katalog/{id}', [BookController::class, 'update'])->name('admin.katalog.update');
    Route::delete('/katalog/{id}', [BookController::class, 'destroy'])->name('admin.katalog.destroy');

    // UBAH JALUR PEMINJAMAN MENJADI STRUKTUR INI
    Route::get('/peminjaman', [BorrowingController::class, 'index']);
    Route::post('/peminjaman', [BorrowingController::class, 'store'])->name('admin.peminjaman.store');
    Route::patch('/peminjaman/booking/{id}/setuju', [BorrowingController::class, 'acceptBooking'])->name('admin.peminjaman.accept');
    Route::delete('/peminjaman/booking/{id}/tolak', [BorrowingController::class, 'rejectBooking'])->name('admin.peminjaman.reject');

    // Rute Anggota Master
    Route::get('/anggota', [MemberController::class, 'index']);
    Route::post('/anggota', [MemberController::class, 'store'])->name('admin.anggota.store');
    Route::put('/anggota/{id}', [MemberController::class, 'update'])->name('admin.anggota.update');
    Route::delete('/anggota/{id}', [MemberController::class, 'destroy'])->name('admin.anggota.destroy');
});

Route::get('/', function () {
    return redirect('/admin');
});
