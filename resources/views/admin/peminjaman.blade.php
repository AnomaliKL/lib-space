@extends('layouts.app')

@section('title', 'Sirkulasi Peminjaman - LibSpace')

@section('content')
<div class="space-y-6" x-data="{ tab: '{{ session('active_tab') ?? 'langsung' }}' }">
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-green-700 animate-fade-in">
            <span>{{ session('success') }}</span>
            <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-red-700 animate-fade-in">
            <span>{{ session('error') }}</span>
            <button class="font-bold hover:text-red-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 pb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Sirkulasi & Pemesanan Buku</h1>
            <p class="text-sm text-gray-500">Pencatatan sirkulasi buku fisik atau validasi booking online mahasiswa.</p>
        </div>

        <div class="flex bg-gray-200/80 p-1 rounded-xl shadow-inner select-none">
            <button 
                @click="tab = 'langsung'" 
                :class="tab === 'langsung' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                class="px-4 py-2 text-sm font-semibold rounded-lg transition duration-200 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Peminjaman Langsung</span>
            </button>
            
            <button 
                @click="tab = 'booking'" 
                :class="tab === 'booking' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                class="px-4 py-2 text-sm font-semibold rounded-lg transition duration-200 flex items-center space-x-2 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span>Antrean Booking</span>
                
                @if($bookingCount > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white animate-pulse">
                    {{ $bookingCount }}
                </span>
                @endif
            </button>
        </div>
    </div>

    <div x-show="tab === 'langsung'" x-transition.opacity.duration.200ms class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start" style="display: none;">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-1">
            <h2 class="text-base font-bold text-gray-800 mb-4">Form Catat Pinjam Fisik</h2>
            <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div x-data="{ 
                    search: '', 
                    open: false, 
                    selectedId: '', 
                    members: [
                        @foreach($members as $member)
                        { id: '{{ $member->id }}', name: '{{ $member->name }}', code: '{{ $member->member_code }}' },
                        @endforeach
                    ],
                    get filteredMembers() {
                        if (this.search === '') return this.members;
                        return this.members.filter(m => m.name.toLowerCase().includes(this.search.toLowerCase()) || m.code.toLowerCase().includes(this.search.toLowerCase()));
                    }
                }" class="relative" @click.away="open = false">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cari Anggota / Mahasiswa</label>
                    
                    <div class="relative">
                        <input type="text" 
                               x-model="search" 
                               @focus="open = true"
                               @input="selectedId = ''" 
                               placeholder="Ketik nama atau kode anggota..." 
                               required 
                               class="w-full text-sm bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <input type="hidden" name="user_id" x-model="selectedId" required>

                    <div x-show="open && filteredMembers.length > 0" 
                         class="absolute z-30 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto"
                         style="display: none;" x-transition>
                        <template x-for="member in filteredMembers" :key="member.id">
                            <div @mousedown="selectedId = member.id; search = member.name + ' (' + member.code + ')'; open = false" 
                                 class="px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition">
                                <span class="font-medium" x-text="member.name"></span> 
                                <span class="text-xs text-gray-400" x-text="'(' + member.code + ')'"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div x-data="{ 
                    search: '', 
                    open: false, 
                    selectedId: '', 
                    books: [
                        @foreach($books as $book)
                        { id: '{{ $book->id }}', title: '{{ $book->title }}', stock: '{{ $book->stock }}' },
                        @endforeach
                    ],
                    get filteredBooks() {
                        if (this.search === '') return this.books;
                        return this.books.filter(b => b.title.toLowerCase().includes(this.search.toLowerCase()));
                    }
                }" class="relative" @click.away="open = false">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cari Judul Koleksi Buku</label>
                    
                    <div class="relative">
                        <input type="text" 
                               x-model="search" 
                               @focus="open = true"
                               @input="selectedId = ''" 
                               placeholder="Ketik judul buku..." 
                               required 
                               class="w-full text-sm bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <input type="hidden" name="book_id" x-model="selectedId" required>

                    <div x-show="open && filteredBooks.length > 0" 
                         class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto"
                         style="display: none;" x-transition>
                        <template x-for="book in filteredBooks" :key="book.id">
                            <div @mousedown="selectedId = book.id; search = book.title; open = false" 
                                 class="px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition flex justify-between items-center">
                                <span class="font-medium truncate mr-2" x-text="book.title"></span> 
                                <span class="text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded whitespace-nowrap" x-text="'Stok: ' + book.stock"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div>
    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Batas Pengembalian</label>
    <input type="date" 
           name="return_deadline" 
           value="{{ date('Y-m-d', strtotime('+7 days')) }}" 
           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
           required 
           class="w-full text-sm bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
                
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm text-sm transition">
                    Simpan Sirkulasi
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden lg:col-span-2">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-800">Daftar Buku Keluar (Sedang Dipinjam)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                            <th class="py-3.5 px-6">Peminjam</th>
                            <th class="py-3.5 px-6">Buku</th>
                            <th class="py-3.5 px-6">Tgl Pinjam</th>
                            <th class="py-3.5 px-6">Batas Kembali</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($borrowedList as $borrow)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 font-medium text-gray-900">{{ $borrow->user->name }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ $borrow->book->title }}</td>
                            <td class="py-4 px-6 text-gray-500">{{ date('d M Y', strtotime($borrow->borrow_date)) }}</td>
                            <td class="py-4 px-6 text-blue-600 font-semibold">{{ date('d M Y', strtotime($borrow->return_deadline)) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-400">Tidak ada buku fisik yang sedang dibawa luar saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="tab === 'booking'" x-transition.opacity.duration.200ms class="space-y-4" style="display: none;">
        @if($bookingCount > 0)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-xl shadow-sm flex items-start justify-between">
            <div class="flex space-x-3">
                <div class="p-1 bg-amber-100 text-amber-700 rounded-lg mt-0.5 animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-amber-800">Pemberitahuan Sistem</h3>
                    <p class="text-xs text-amber-700 mt-0.5">Sistem mendeteksi ada <span class="font-bold text-amber-900">{{ $bookingCount }} permintaan booking</span> online aktif yang diajukan mahasiswa. Tolong segera validasi kesiapan bukunya.</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-amber-600 uppercase bg-amber-100 px-2 py-0.5 rounded-full whitespace-nowrap">Antrean</span>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-800">Daftar Reservasi Mandiri (Web-App)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                            <th class="py-3.5 px-6">Nama Anggota</th>
                            <th class="py-3.5 px-6">Buku Yang Dibooking</th>
                            <th class="py-3.5 px-6">Batas Ambil Fisik</th>
                            <th class="py-3.5 px-6 text-center">Tindakan Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($bookingList as $booking)
                        <tr class="bg-amber-50/10">
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <span class="text-xs text-gray-400">{{ $booking->user->member_code }}</span>
                            </td>
                            <td class="py-4 px-6 text-gray-600 font-medium">{{ $booking->book->title }}</td>
                            <td class="py-4 px-6 text-amber-600 font-semibold">{{ date('d M Y', strtotime($booking->return_deadline)) }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="/admin/peminjaman/booking/{{ $booking->id }}/setuju" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-md shadow transition">
                                            Setujui
                                        </button>
                                    </form>
                                    
                                    <form action="/admin/peminjaman/booking/{{ $booking->id }}/tolak" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-white text-red-600 border border-red-200 hover:bg-red-50 text-xs font-bold rounded-md transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-400">Antrean pemesanan online kosong bersih.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection