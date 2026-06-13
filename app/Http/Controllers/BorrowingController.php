<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    // 1. READ: Menampilkan data ke kedua Tab (Peminjaman Aktif & Antrean Booking)
    public function index()
    {
        // Ambil data untuk form dropdown
        $members = User::where('role', 'Member')->where('status', 'Active')->get();
        $books = Book::where('stock', '>', 0)->get();

        // Ambil riwayat buku yang sedang dibawa mahasiswa (Status: Borrowed)
        $borrowedList = Borrowing::with(['user', 'book'])->where('status', 'Borrowed')->latest()->get();

        // Ambil antrean booking mahasiswa via web yang butuh persetujuan (Status: Booking)
        $bookingList = Borrowing::with(['user', 'book'])->where('status', 'Booking')->latest()->get();

        // Hitung jumlah antrean booking aktif untuk angka badge notifikasi merah
        $bookingCount = $bookingList->count();

        return view('admin.peminjaman', compact('members', 'books', 'borrowedList', 'bookingList', 'bookingCount'));
    }

    // 2. CREATE: Simpan sirkulasi langsung dari meja petugas
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'return_deadline' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Validasi pengaman jika stok mendadak habis
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Stok fisik buku ini sedang kosong!');
        }

        // Catat transaksi
        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => now()->toDateString(),
            'return_deadline' => $request->return_deadline,
            'status' => 'Borrowed',
        ]);

        // Kurangi stok buku
        $book->decrement('stock');

        return redirect()->back()->with('success', 'Sirkulasi peminjaman langsung berhasil disimpan!');
    }

    // 3. UPDATE: Menyetujui Booking Online (Berubah dari Booking -> Borrowed)
    public function acceptBooking($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $book = Book::findOrFail($borrowing->book_id);

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Gagal menyetujui, stok fisik buku habis!');
        }

        // Ubah status dan isi tanggal pinjam awal jadi hari ini
        $borrowing->update([
            'borrow_date' => now()->toDateString(),
            'return_deadline' => now()->addDays(7)->toDateString(), // Otomatis durasi pinjam 7 hari
            'status' => 'Borrowed',
        ]);

        // Kurangi stok fisik buku
        $book->decrement('stock');

        return redirect()->back()->with('success', 'Booking online mahasiswa berhasil disetujui! Buku siap diambil.');
    }

    // 4. DELETE: Tolak / Batalkan Permintaan Booking Online
    public function rejectBooking($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete(); // Hapus antrean booking dari log

        return redirect()->back()->with('success', 'Permintaan booking online berhasil ditolak dan dibersihkan.');
    }

    // 5. READ: Menampilkan halaman sirkulasi pengembalian buku
    public function returnIndex()
    {
        // Tarik data transaksi yang Sedang Dipinjam (Borrowed) dan Sudah Kembali (Returned)
        $transactions = Borrowing::with(['user', 'book'])
            ->whereIn('status', ['Borrowed', 'Returned'])
            ->latest()
            ->get();

        // Hitung denda berjalan secara real-time untuk buku yang belum dikembalikan
        foreach ($transactions as $trans) {
            if ($trans->status === 'Borrowed' && now()->startOfDay() > date($trans->return_deadline)) {
                $statusDeadline = now()->startOfDay()->diffInDays(date($trans->return_deadline));
                $trans->calculated_fine = $statusDeadline * 2000; // Tarif denda Rp 2.000 / hari
                $trans->days_late = $statusDeadline;
            } else {
                $trans->calculated_fine = $trans->fine; // Gunakan denda permanen jika sudah selesai
                $trans->days_late = 0;
            }
        }

        return view('admin.pengembalian', compact('transactions'));
    }

    // 6. UPDATE: Proses pengembalian fisik buku & pelunasan denda
    public function processReturn(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $book = Book::findOrFail($borrowing->book_id);

        // Jika telat, kunci nominal denda berjalan saat tombol diklik ke dalam database
        $fineAmount = 0;
        if (now()->startOfDay() > date($borrowing->return_deadline)) {
            $daysLate = now()->startOfDay()->diffInDays(date($borrowing->return_deadline));
            $fineAmount = $daysLate * 2000;
        }

        // Perbarui status transaksi
        $borrowing->update([
            'returned_at' => now()->toDateString(),
            'fine' => $fineAmount,
            'status' => 'Returned',
        ]);

        // Kembalikan jumlah stok fisik buku ke rak (+1)
        $book->increment('stock');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan! Stok rak telah diperbarui.');
    }
}
