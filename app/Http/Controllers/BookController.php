<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 1. READ: Menampilkan semua koleksi buku admin dari database
    public function index()
    {
        $books = Book::latest()->get();

        return view('admin.katalog', compact('books'));
    }

    // 2. CREATE: Menyimpan buku baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        Book::create($request->all());

        return redirect()->back()->with('success', 'Buku baru berhasil ditambahkan ke koleksi!');
    }

    // 3. UPDATE: Memperbarui informasi atau stok buku
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($request->all());

        return redirect()->back()->with('success', 'Informasi buku berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus buku dari sistem katalog
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}
