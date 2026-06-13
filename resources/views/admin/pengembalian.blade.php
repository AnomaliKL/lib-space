@extends('layouts.app')

@section('title', 'Manajemen Pengembalian - LibSpace')

@section('content')
<div class="space-y-6">
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-green-700 animate-fade-in">
            <span>{{ session('success') }}</span>
            <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Sirkulasi Pengembalian Buku</h1>
        <p class="text-sm text-gray-500">Pencatatan buku kembali, cek durasi pinjam, dan manajemen denda.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-base font-bold text-gray-800">Daftar Pengembalian & Denda</h2>
            <div class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg border border-blue-100 font-semibold">
                Tarif Keterlambatan: Rp 2.000 / Hari
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                        <th class="py-4 px-6">Nama Anggota</th>
                        <th class="py-4 px-6">Buku</th>
                        <th class="py-4 px-6">Batas Kembali</th>
                        <th class="py-4 px-6">Tgl Dikembalikan</th>
                        <th class="py-4 px-6">Status Denda</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($transactions as $trans)
                    <tr class="hover:bg-gray-50 transition duration-150 {{ $trans->status === 'Borrowed' && now()->startOfDay() > date($trans->return_deadline) ? 'bg-red-50/20' : '' }}">
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900">{{ $trans->user->name }}</div>
                            <span class="text-xs text-gray-400 font-mono">{{ $trans->user->member_code ?? '#ADMIN' }}</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600 font-medium">{{ $trans->book->title }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ date('d M Y', strtotime($trans->return_deadline)) }}</td>
                        <td class="py-4 px-6 text-gray-500">
                            {{ $trans->returned_at ? date('d M Y', strtotime($trans->returned_at)) : 'Belum Dikembalikan' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($trans->status === 'Returned')
                                @if($trans->fine > 0)
                                    <span class="text-red-600 font-bold flex items-center">
                                        Rp {{ number_format($trans->fine) }} <span class="text-xs text-gray-400 font-normal ml-1">(Lunas)</span>
                                    </span>
                                @else
                                    <span class="text-green-600 font-semibold">Rp 0 (Tepat Waktu)</span>
                                @endif
                            @else
                                @if($trans->calculated_fine > 0)
                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded border border-red-100 animate-pulse">
                                        Rp {{ number_format($trans->calculated_fine) }} ({{ $trans->days_late }} Hari Telat)
                                    </span>
                                @else
                                    <span class="text-indigo-600 font-medium">Dalam Masa Pinjam</span>
                                @endif
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($trans->status === 'Returned')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                    Selesai
                                </span>
                            @else
                                <form action="{{ route('admin.peminjaman.return', $trans->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white rounded-lg shadow transition
                                        {{ $trans->calculated_fine > 0 ? 'bg-amber-500 hover:bg-amber-600 shadow-amber-500/10' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/10' }}">
                                        {{ $trans->calculated_fine > 0 ? 'Bayar Denda & Kembali' : 'Proses Kembali' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">Belum ada riwayat transaksi sirkulasi di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection