@extends('layouts.member-app')

@section('title', 'Riwayat Pembiayaan & Pinjaman - LibSpace')

@section('content')
<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Riwayat Aktivitas Peminjaman</h1>
            <p class="text-sm text-gray-500 mt-0.5">Pantau status validasi booking, batas waktu pengembalian, dan riwayat denda sirkulasi kamu di sini.</p>
        </div>
        <a href="{{ route('member.dashboard') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-100 px-3.5 py-2 rounded-xl transition duration-200">
            <span>🔍 Cari Buku Lain</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">📜</div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $myBorrowings->count() }}</div>
                <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Transaksi</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner">📖</div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $myBorrowings->whereIn('status', ['Approved', 'Borrowed'])->count() }}</div>
                <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">Sedang Dipinjam / Siap Ambil</div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-inner">💸</div>
            <div>
                <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($myBorrowings->sum('fine'), 0, ',', '.') }}</div>
                <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">Akumulasi Denda</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-700">Log Peminjaman Buku</h2>
            <span class="text-[11px] bg-white border border-gray-200 px-2.5 py-1 rounded-md text-gray-400 font-medium">Auto-update sistem</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/40 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3 px-6">Informasi Buku</th>
                        <th class="py-3 px-6">Tanggal Pinjam</th>
                        <th class="py-3 px-6">Batas Kembali</th>
                        <th class="py-3 px-6">Tanggal Kembali</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-xs text-gray-600">
                    @forelse($myBorrowings as $borrowing)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 text-sm line-clamp-1">{{ $borrowing->book->title }}</span>
                                    <span class="text-[11px] text-gray-400 mt-0.5">Penulis: {{ $borrowing->book->author }}</span>
                                </div>
                            </td>
                            
                            <td class="py-4 px-6 font-medium">
                                {{ $borrowing->borrow_date ? \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d M Y') : '-' }}
                            </td>
                            
                            <td class="py-4 px-6 font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($borrowing->return_deadline)->translatedFormat('d M Y') }}
                            </td>
                            
                            <td class="py-4 px-6 font-medium">
                                @if($borrowing->returned_at)
                                    <span class="text-green-600">{{ \Carbon\Carbon::parse($borrowing->returned_at)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span class="text-gray-400 italic">Belum kembali</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6">
                                @if($borrowing->status === 'Booking')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-blue-50 text-blue-600 border border-blue-100">
                                        ⏳ Menunggu Persetujuan
                                    </span>
                                @elseif($borrowing->status === 'Approved')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-amber-50 text-amber-600 border border-amber-100 animate-pulse">
                                        📦 Siap Diambil
                                    </span>
                                @elseif($borrowing->status === 'Borrowed')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-purple-50 text-purple-600 border border-purple-100">
                                        📖 Sedang Dipinjam
                                    </span>
                                @elseif($borrowing->status === 'Returned')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-green-50 text-green-600 border border-green-100">
                                        ✅ Selesai Dikembalikan
                                    </span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 text-right font-bold {{ $borrowing->fine > 0 ? 'text-red-500' : 'text-gray-400' }}">
                                @if($borrowing->fine > 0)
                                    Rp {{ number_format($borrowing->fine, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center text-gray-400 italic">
                                Kamu belum memiliki riwayat aktivitas peminjaman atau booking buku di LibSpace.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection