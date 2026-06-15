<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category; // Jalankan import model kategori
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        // Mengambil buku dengan banyak kategori sekaligus
        $books = Book::with('categories')->latest()->get();
        $categories = Category::latest()->get();

        return view('admin.katalog', compact('books', 'categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_ids' => 'required|array', // Memastikan yang dikirim adalah array ID
            'stock' => 'required|integer|min:0',
        ]);

        $book = Book::create($request->only(['title', 'author', 'stock']));
        $book->categories()->sync($request->category_ids); // Sinkronisasi array ID ke tabel pivot

        return redirect()->back()->with('success', 'Buku baru berhasil ditambahkan ke koleksi!');
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($request->only(['title', 'author', 'stock']));
        $book->categories()->sync($request->category_ids); // Perbarui relasi di tabel pivot

        return redirect()->back()->with('success', 'Informasi buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}
