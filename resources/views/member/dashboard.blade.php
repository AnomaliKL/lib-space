@extends('layouts.member-app')

@section('title', 'Dashboard Mahasiswa - LibSpace')

@section('content')
<!-- State searchQuery dan selectedCategory untuk filter real-time katalog di sisi mahasiswa -->
<div class="space-y-8" x-data="{ searchQuery: '', selectedCategory: '' }">

    <!-- NOTIFIKASI SUKSES / GAGAL -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-green-700 animate-fade-in">
            <div class="flex items-center space-x-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
            <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-red-700 animate-fade-in">
            <div class="flex items-center space-x-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
            <button class="font-bold hover:text-red-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- HERO WELCOME BANNER -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl font-bold select-none">TRPL</div>
        <div class="max-w-xl space-y-2 relative z-10">
            <span class="px-3 py-1 bg-white/20 text-white text-xs font-semibold rounded-full uppercase tracking-wider backdrop-blur-sm">Ruang Mahasiswa</span>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selamat Datang di Katalog LibSpace</h1>
            <p class="text-sm text-blue-100 leading-relaxed">Cari referensi pemrograman, slicing framework frontend, rancangan database, hingga laporan Tugas Akhir secara kilat di sini.</p>
        </div>
    </div>

    <!-- CARDS PANEL RINGKASAN STATUS MAHASISWA -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">📚</div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $books->where('stock', '>', 0)->count() }}</div>
                <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">Buku Siap Pinjam</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner">⏳</div>
            <div>
                <div class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-100 inline-block mb-0.5">Sirkulasi Aktif</div>
                <div class="text-xs text-gray-400">Pantau batas waktu kembali di menu riwayat.</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-inner">💳</div>
            <div>
                <div class="text-2xl font-bold text-gray-800">Rp 2.000 <span class="text-xs font-normal text-gray-400">/hari</span></div>
                <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">Tarif Denda Keterlambatan</div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH PANEL -->
    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-4">
        <!-- Input Pencarian -->
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 select-none">🔍</span>
            <input 
                type="text" 
                x-model="searchQuery" 
                placeholder="Ketik judul buku pemrograman atau nama penulis yang kamu cari..." 
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 transition placeholder:text-gray-400"
            >
        </div>
        <!-- Dropdown Kategori -->
        <div class="w-full sm:w-64">
            <select 
                x-model="selectedCategory" 
                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 transition"
            >
                <option value="">Semua Ragam Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- GRID ETALASE BUKU -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($books as $book)
        <!-- Menggunakan x-show untuk penyaringan dinamis instant berbasis Alpine.js -->
        <div 
            x-show="
                (searchQuery === '' || '{{ strtolower($book->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($book->author) }}'.includes(searchQuery.toLowerCase())) &&
                (selectedCategory === '' || {{ json_encode($book->categories->pluck('id')) }}.includes(parseInt(selectedCategory)))
            "
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between transition duration-300 hover:shadow-md hover:-translate-y-0.5 group"
        >
            <div class="p-4 space-y-4">
                <!-- Cover Area -->
                @if($book->cover_url)
                    <div class="h-52 w-full rounded-lg overflow-hidden border border-gray-100 shadow-inner relative bg-gray-50">
                        <img src="{{ Str::startsWith($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                @else
                    <div class="h-52 rounded-lg flex items-center justify-center p-4 text-center select-none bg-gradient-to-br from-slate-700 to-slate-900 shadow-inner">
                        <span class="text-white font-bold text-sm tracking-wide shadow-sm line-clamp-3">{{ $book->title }}</span>
                    </div>
                @endif
                
                <!-- Metadata Content -->
                <div class="space-y-2">
                    <div class="flex flex-wrap gap-1">
                        @foreach($book->categories as $category)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100/50">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h3 class="text-base font-bold text-gray-800 mt-1 line-clamp-2 min-h-[3rem] leading-snug group-hover:text-blue-600 transition" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    
                    <p class="text-xs text-gray-400">Penulis: <span class="font-medium text-gray-600">{{ $book->author }}</span></p>
                    
                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed bg-gray-50 p-2 rounded-lg italic" title="{{ $book->description }}">
                        {{ $book->description ?? 'Tidak ada sinopsis ringkas untuk koleksi buku ini.' }}
                    </p>
                </div>
            </div>
            
            <!-- Footer Action Button -->
            <div class="p-4 pt-0 border-t border-gray-50 flex items-center justify-between mt-auto bg-gray-50/50">
                @if($book->stock > 0)
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-medium uppercase">Tersedia</span>
                        <span class="text-xs text-green-600 font-bold">Stok: {{ $book->stock }} Rak</span>
                    </div>
                    
                    <!-- Form Booking Mandiri -->
                    <form action="{{ route('member.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition duration-200 flex items-center space-x-1">
                            <span>📌 Booking</span>
                        </button>
                    </form>
                @else
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-medium uppercase">Kondisi</span>
                        <span class="text-xs text-red-500 font-bold">Sedang Kosong</span>
                    </div>
                    <button type="button" disabled class="px-3 py-1.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-lg cursor-not-allowed border border-gray-200">
                        Habis
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 bg-white border border-dashed border-gray-200 rounded-xl p-12 text-center text-gray-400">
            Koleksi buku belum tersedia di dalam sistem perpustakaan LibSpace.
        </div>
        @endforelse
    </div>

</div>
@endsection