<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    // Menampilkan halaman katalog buku utama area mahasiswa
    public function index()
    {
        // Ambil semua buku beserta kategori pendukungnya
        $books = Book::with('categories')->latest()->get();
        $categories = Category::latest()->get();

        return view('member.dashboard', compact('books', 'categories'));
    }

    // Memproses booking buku secara mandiri oleh mahasiswa via Web
    public function storeBooking(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Validasi: Pastikan stok buku di rak masih tersedia sebelum dibooking
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku fisik di rak sedang kosong dan belum bisa dibooking.');
        }

        // Catat transaksi dengan status awal 'Booking'
        Borrowing::create([
            'user_id' => Auth::id() ?? 2, // Menggunakan ID User login, fallback ke ID 2 (Diva) jika belum pasang auth
            'book_id' => $request->book_id,
            'borrow_date' => null, // Belum diisi karena buku fisik belum diambil di perpustakaan
            'return_deadline' => now()->addDays(2)->toDateString(), // Batas waktu ambil fisik (misal: 2 hari semenjak booking)
            'status' => 'Booking', // Status masuk antrean awal
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dibooking! Silakan datang ke perpustakaan sebelum batas waktu ambil.');
    }

    // Menampilkan riwayat sirkulasi personal milik mahasiswa
    public function history()
    {
        $userId = Auth::id() ?? 2; // Menggunakan ID User login, fallback ke ID 2 (Diva)

        // Tarik semua log transaksi milik mahasiswa bersangkutan
        $myBorrowings = Borrowing::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('member.riwayat', compact('myBorrowings'));
    }
}
