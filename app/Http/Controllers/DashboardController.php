<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total stok seluruh fisik buku yang ada
        $totalBooks = Book::sum('stock');

        // 2. Hitung berapa buku yang saat ini sedang dibawa mahasiswa (Status: Borrowed)
        $borrowedBooks = Borrowing::where('status', 'Borrowed')->count();

        // 3. Hitung jumlah user dengan role Member yang statusnya Active
        $activeMembers = User::where('role', 'Member')->where('status', 'Active')->count();

        // 4. Ambil 5 aktivitas transaksi sirkulasi paling baru (untuk tabel log bawah)
        $recentActivities = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Data Dummy Grafik Tren Peminjaman 7 hari terakhir (Senin - Minggu)
        $chartData = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data' => [12, 19, 3, 5, 2, 3, 10], // Angka simulasi intensitas sirkulasi
        ];

        return view('admin.dashboard', compact('totalBooks', 'borrowedBooks', 'activeMembers', 'recentActivities', 'chartData'));
    }
}
