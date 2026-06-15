@extends('layouts.app')

@section('title', 'Katalog Buku - LibSpace')

@section('content')
<div class="space-y-6" x-data="{ openAddModal: false, openEditModal: false, openDeleteModal: false, openCategoryModal: false, currentBook: {id: '', title: '', author: '', category_ids: [], stock: 0}, deleteUrl: '' }">

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-green-700 animate-fade-in">
            <span>{{ session('success') }}</span>
            <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Katalog Koleksi Buku (Admin)</h1>
            <p class="text-sm text-gray-500">Kelola master data koleksi buku referensi pemrograman dan laporan Tugas Akhir.</p>
        </div>
        <div class="flex space-x-2 self-start md:self-auto">
            <button @click="openCategoryModal = true" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg border border-gray-200 transition flex items-center space-x-2">
                <span>📂 + Kategori</span>
            </button>
            <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm flex items-center space-x-2 transition">
                <span>+ Tambah Buku</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($books as $book)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between transition duration-200 hover:shadow-md">
            <div class="p-5 space-y-4">
                
                <div class="h-40 rounded-lg flex items-center justify-center p-4 text-center select-none bg-gradient-to-br from-slate-700 to-slate-900">
                    <span class="text-white font-bold text-lg tracking-wide shadow-sm">{{ $book->title }}</span>
                </div>
                
                <div class="space-y-2">
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($book->categories as $category)
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mt-2 line-clamp-1"> {{$book->title}}</h3>
                    <p class="text-xs text-gray-400">Oleh: <span class="font-medium text-gray-600">{{ $book->author }}</span></p>
                </div>
            </div>
            
            <div class="p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-auto">
                @if($book->stock > 0)
                    <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded border border-green-100">Tersedia (Stok: {{ $book->stock }})</span>
                @else
                    <span class="text-xs text-red-600 font-semibold bg-red-50 px-2 py-1 rounded border border-red-100">Kosong (Habis)</span>
                @endif
                
                <div class="flex space-x-1.5">
                    <button @click="currentBook = {id: '{{ $book->id }}', title: '{{ $book->title }}', author: '{{ $book->author }}', category_ids: {{ json_encode($book->categories->pluck('id')) }}, stock: '{{ $book->stock }}'}; openEditModal = true" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded transition shadow-sm">
                        Edit
                    </button>
                    <button @click="deleteUrl = '/admin/katalog/{{ $book->id }}'; openDeleteModal = true" class="px-2.5 py-1.5 bg-white text-red-600 border border-gray-200 hover:bg-red-50 text-xs font-semibold rounded transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white border border-dashed border-gray-200 rounded-xl p-12 text-center text-gray-400">
            Belum ada koleksi buku di dalam database.
        </div>
        @endforelse
    </div>

    <template x-teleport="body">
        <div x-show="openCategoryModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" style="display: none;">
            <div x-show="openCategoryModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" @click="openCategoryModal = false"></div>
            <div x-show="openCategoryModal" class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-gray-100 relative z-10">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">Tambah Master Kategori</h3>
                    <button @click="openCategoryModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori Baru</label>
                        <input type="text" name="name" placeholder="Contoh: Mobile Development..." required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="openCategoryModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openAddModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" style="display: none;">
            <div x-show="openAddModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" @click="openAddModal = false"></div>
            <div x-show="openAddModal" class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-gray-100 relative z-10 my-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">Tambah Koleksi Buku Baru</h3>
                    <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form action="{{ route('admin.katalog.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Judul Lengkap Buku</label>
                        <input type="text" name="title" placeholder="Masukkan judul buku..." required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Penulis</label>
                        <input type="text" name="author" placeholder="Nama penulis..." required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Pilih Kategori (Bisa Pilih Lebih dari Satu)</label>
                        <div class="grid grid-cols-2 gap-2 mt-2 max-h-32 overflow-y-auto p-2 bg-gray-50 border border-gray-200 rounded-xl">
                            @foreach($categories as $category)
                                <label class="inline-flex items-center text-sm text-gray-700 space-x-2 p-1 hover:bg-white rounded cursor-pointer">
                                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="rounded text-blue-600 focus:ring-blue-500">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah Stok Fisik</label>
                        <input type="number" name="stock" value="1" min="0" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="openAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">Simpan Koleksi</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openEditModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" style="display: none;">
            <div x-show="openEditModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" @click="openEditModal = false"></div>
            <div x-show="openEditModal" class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-gray-100 relative z-10 my-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">Edit Informasi Buku</h3>
                    <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 text-2xl transition">&times;</button>
                </div>
                <form :action="'/admin/katalog/' + currentBook.id" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Judul Lengkap Buku</label>
                        <input type="text" name="title" x-model="currentBook.title" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Penulis</label>
                        <input type="text" name="author" x-model="currentBook.author" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kategori Buku (Multi-select)</label>
                        <div class="grid grid-cols-2 gap-2 mt-2 max-h-32 overflow-y-auto p-2 bg-gray-50 border border-gray-200 rounded-xl">
                            @foreach($categories as $category)
                                <label class="inline-flex items-center text-sm text-gray-700 space-x-2 p-1 hover:bg-white rounded cursor-pointer">
                                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" :checked="currentBook.category_ids.includes({{ $category->id }})" class="rounded text-blue-600 focus:ring-blue-500">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah Stok</label>
                        <input type="number" name="stock" x-model="currentBook.stock" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-md transition">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openDeleteModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" style="display: none;">
            <div x-show="openDeleteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" @click="openDeleteModal = false"></div>
            <div x-show="openDeleteModal" class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 border border-gray-100 relative z-10 text-center space-y-4 my-8">
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold border border-red-100">⚠️</div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Hapus Buku Ini?</h3>
                    <p class="text-xs text-gray-500 mt-1">Tindakan ini permanen. Buku akan dihapus dari katalog dan riwayat sirkulasi terkait akan ikut terhapus.</p>
                </div>
                <form :action="deleteUrl" method="POST" class="flex justify-center space-x-2 pt-4 border-t border-gray-100">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="openDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-md transition">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </template>

</div>
@endsection