<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Jalankan import facade Storage

class BookController extends Controller
{
    public function index()
    {
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
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Aturan upload gambar max 2MB
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'stock' => 'required|integer|min:0',
        ]);

        // Tampung data inputan teks terlebih dahulu
        $data = $request->only(['title', 'author', 'description', 'stock']);

        // Jika user memilih file gambar cover, proses pemindahan berkasnya
        if ($request->hasFile('cover_file')) {
            // File disimpan ke folder 'storage/app/public/covers' dan menghasilkan path acak yang unik
            $path = $request->file('cover_file')->store('covers', 'public');
            $data['cover_url'] = $path; // Amankan path-nya untuk disimpan ke kolom 'cover_url' tabel books
        }

        $book = Book::create($data);
        $book->categories()->sync($request->category_ids);

        return redirect()->back()->with('success', 'Buku baru berhasil ditambahkan ke koleksi!');
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->only(['title', 'author', 'description', 'stock']);

        if ($request->hasFile('cover_file')) {
            // Hapus file cover lama di lokal storage agar memori server tidak boncos (opsional tapi best-practice TRPL)
            if ($book->cover_url && ! Str::startsWith($book->cover_url, 'http') && Storage::disk('public')->exists($book->cover_url)) {
                Storage::disk('public')->delete($book->cover_url);
            }

            // Simpan berkas cover baru
            $path = $request->file('cover_file')->store('covers', 'public');
            $data['cover_url'] = $path;
        }

        $book->update($data);
        $book->categories()->sync($request->category_ids);

        return redirect()->back()->with('success', 'Informasi buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Hapus berkas fisiknya saat baris buku di-delete
        if ($book->cover_url && ! Str::startsWith($book->cover_url, 'http') && Storage::disk('public')->exists($book->cover_url)) {
            Storage::disk('public')->delete($book->cover_url);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}
