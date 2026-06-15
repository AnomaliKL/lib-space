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

        // Peminjaman langsung di meja petugas hanya boleh memilih buku yang stoknya di atas 0
        $books = Book::where('stock', '>', 0)->get();

        // Ambil riwayat buku yang sedang dibawa mahasiswa (Status: Borrowed)
        $borrowedList = Borrowing::with(['user', 'book'])->where('status', 'Borrowed')->latest()->get();

        // Ambil antrean booking yang berstatus 'Booking' DAN 'Approved' (Siap Diambil)
        $bookingList = Borrowing::with(['user', 'book'])
            ->whereIn('status', ['Booking', 'Approved'])
            ->latest()
            ->get();

        // Hitung jumlah antrean booking yang MURNI masih 'Booking' (untuk angka badge notifikasi merah)
        $bookingCount = Borrowing::where('status', 'Booking')->count();

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

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Stok fisik buku ini sedang kosong!');
        }

        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => now()->toDateString(),
            'return_deadline' => $request->return_deadline,
            'status' => 'Borrowed',
        ]);

        // Potong stok karena dipinjam langsung di tempat
        $book->decrement('stock');

        return redirect()->back()->with('success', 'Sirkulasi peminjaman langsung berhasil disimpan!');
    }

    // 3. UPDATE: Menyetujui Booking Online (Booking -> Approved)
    public function acceptBooking($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $book = Book::findOrFail($borrowing->book_id);

        // Validasi pengaman: pastikan saat disetujui, buku masih ada stoknya
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Gagal menyetujui, stok fisik buku habis!');
        }

        // Ubah status ke Approved (Beluam memotong stok & belum ada borrow_date)
        $borrowing->update([
            'status' => 'Approved',
        ]);

        return redirect()->back()->with('success', 'Permintaan booking online berhasil disetujui! Menunggu mahasiswa mengambil buku.');
    }

    // 3.5. UPDATE (FUNGSI BARU): Mengubah status dari Approved -> Borrowed (Buku Diambil Fisik)
    public function takeBook($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $book = Book::findOrFail($borrowing->book_id);

        // Validasi double check stok fisik sebelum benar-benar dibawa pulang
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Gagal memproses, stok fisik buku mendadak habis!');
        }

        // Sekarang isi tanggal pinjam resmi hari ini dan kunci durasi kembali 7 hari
        $borrowing->update([
            'borrow_date' => now()->toDateString(),
            'return_deadline' => now()->addDays(7)->toDateString(),
            'status' => 'Borrowed',
        ]);

        // Stok baru resmi berkurang saat buku fisik diambil
        $book->decrement('stock');

        return redirect()->back()->with('with_tab', 'booking')->with('success', 'Konfirmasi sukses! Buku telah diambil oleh mahasiswa.');
    }

    // 4. DELETE: Tolak / Batalkan Permintaan Booking Online
    public function rejectBooking($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->back()->with('with_tab', 'booking')->with('success', 'Permintaan booking online berhasil ditolak dan dibersihkan.');
    }

    // 5. READ: Menampilkan halaman sirkulasi pengembalian buku
    public function returnIndex()
    {
        $transactions = Borrowing::with(['user', 'book'])
            ->whereIn('status', ['Borrowed', 'Returned'])
            ->latest()
            ->get();

        foreach ($transactions as $trans) {
            if ($trans->status === 'Borrowed' && now()->startOfDay() > date($trans->return_deadline)) {
                $statusDeadline = now()->startOfDay()->diffInDays(date($trans->return_deadline));
                $trans->calculated_fine = $statusDeadline * 2000; // Denda Rp 2.000 / hari
                $trans->days_late = $statusDeadline;
            } else {
                $trans->calculated_fine = $trans->fine;
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

        $fineAmount = 0;
        if (now()->startOfDay() > date($borrowing->return_deadline)) {
            $daysLate = now()->startOfDay()->diffInDays(date($borrowing->return_deadline));
            $fineAmount = $daysLate * 2000;
        }

        $borrowing->update([
            'returned_at' => now()->toDateString(),
            'fine' => $fineAmount,
            'status' => 'Returned',
        ]);

        $book->increment('stock');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan! Stok rak telah diperbarui.');
    }
}
