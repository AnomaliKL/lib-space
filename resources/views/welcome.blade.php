@extends('layouts.app')

@section('title', 'Dashboard Admin - LibSpace')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Ringkasan data, statistik, dan aktivitas sirkulasi perpustakaan LibSpace.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Koleksi Buku</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">1,240</h3>
                <span class="text-xs text-green-600 font-medium mt-2 block">▲ 12 Buku baru minggu ini</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Buku Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">84</h3>
                <span class="text-xs text-amber-600 font-medium mt-2 block">● 5 Buku melewati batas waktu</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Anggota Aktif</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">312</h3>
                <span class="text-xs text-blue-600 font-medium mt-2 block">Warga & Mahasiswa lokal</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Grafik Tren Peminjaman</h2>
                <p class="text-xs text-gray-500">Memantau intensitas minat baca pengguna.</p>
            </div>
            <div class="flex items-center space-x-2">
                <select class="text-sm bg-gray-50 border border-gray-300 rounded-lg p-2 text-gray-700">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
        </div>
        <div class="h-48 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
            <span class="text-sm font-medium">Visualisasi Chart (Mingguan / Bulanan) Ter-render di Sini</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Daftar Aktivitas Peminjaman Aktif</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                        <th class="py-4 px-6">Nama Peminjam</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Tanggal Pinjam</th>
                        <th class="py-4 px-6">Batas Pengembalian</th>
                        <th class="py-4 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">Ahmad Fauzi</td>
                        <td class="py-4 px-6">Belajar Laravel 11 Pemula</td>
                        <td class="py-4 px-6">10 Juni 2026</td>
                        <td class="py-4 px-6 font-semibold text-blue-600">17 Juni 2026</td>
                        <td class="py-4 px-6"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Dipinjam</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">Siti Rahma</td>
                        <td class="py-4 px-6">Mastering React & Tailwind CSS</td>
                        <td class="py-4 px-6">08 Juni 2026</td>
                        <td class="py-4 px-6 font-semibold text-blue-600">15 Juni 2026</td>
                        <td class="py-4 px-6"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Dipinjam</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 font-medium">Rian Hidayat</td>
                        <td class="py-4 px-6">Dasar Infrastruktur Jaringan Web</td>
                        <td class="py-4 px-6">01 Juni 2026</td>
                        <td class="py-4 px-6 font-semibold text-blue-600">08 Juni 2026</td>
                        <td class="py-4 px-6"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Dipinjam</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection