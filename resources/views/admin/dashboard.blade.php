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
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Fisik Buku</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalBooks) }} <span class="text-sm font-normal text-gray-400">Eks</span></h3>
                <span class="text-xs text-green-600 font-medium mt-2 block">▲ Tersedia di rak perpustakaan</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Buku Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $borrowedBooks }} <span class="text-sm font-normal text-gray-400">Buku</span></h3>
                <span class="text-xs text-amber-600 font-medium mt-2 block">● Aktif dibawa oleh mahasiswa</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Anggota Aktif</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $activeMembers }} <span class="text-sm font-normal text-gray-400">User</span></h3>
                <span class="text-xs text-blue-600 font-medium mt-2 block">Warga TRPL terverifikasi</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Grafik Tren Peminjaman</h2>
                <p class="text-xs text-gray-500">Memantau intensitas minat baca pengguna mingguan.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md font-semibold border border-blue-100">Live Database</span>
            </div>
        </div>
        <div class="h-64 relative w-full">
            <canvas id="loanTrendChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Daftar Aktivitas Sirkulasi Terkini</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                        <th class="py-4 px-6">Nama Peminjam</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Tanggal Sirkulasi</th>
                        <th class="py-4 px-6">Batas Waktu / Selesai</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($recentActivities as $activity)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $activity->user->name }}</td>
                        <td class="py-4 px-6 text-gray-600">{{ $activity->book->title }}</td>
                        <td class="py-4 px-6 text-gray-500">
                            {{ $activity->borrow_date ? date('d M Y', strtotime($activity->borrow_date)) : 'Diajukan via Web' }}
                        </td>
                        <td class="py-4 px-6 font-medium">
                            @if($activity->status === 'Returned')
                                <span class="text-gray-400 line-through">{{ date('d M Y', strtotime($activity->return_deadline)) }}</span>
                            @else
                                <span class="text-blue-600">{{ date('d M Y', strtotime($activity->return_deadline)) }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($activity->status === 'Borrowed')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Dipinjam</span>
                            @elseif($activity->status === 'Booking')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">Booking (Web)</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">Kembali</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400">Belum ada aktivitas sirkulasi transaksi saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('loanTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'Jumlah Buku Keluar',
                    data: {!! json_encode($chartData['data']) !!},
                    borderColor: 'rgb(37, 99, 235)', // Blue-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(37, 99, 235)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.04)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection