@extends('layouts.app')

@section('title', 'Data Anggota - LibSpace')

@section('content')
<div class="space-y-6" x-data="{ 
    openAddModal: false, 
    openEditModal: false, 
    openDeleteModal: false, 
    openToggleModal: false,
    currentMember: {id: '', member_code: '', name: '', email: '', status: 'Active'}, 
    deleteUrl: '',
    toggleUrl: '',
    toggleActionText: ''
}">
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center text-sm text-green-700 animate-fade-in">
            <span>{{ session('success') }}</span>
            <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Master Anggota</h1>
            <p class="text-sm text-gray-500">Kelola informasi profile, status keanggotaan, dan hak akses sirkulasi.</p>
        </div>
        <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm flex items-center space-x-2 transition">
            <span>+ Tambah Anggota</span>
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase border-b border-gray-100">
                        <th class="py-4 px-6">ID Anggota</th>
                        <th class="py-4 px-6">Nama Lengkap</th>
                        <th class="py-4 px-6">Kontak/Email</th>
                        <th class="py-4 px-6 text-center">Buku Aktif</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($members as $member)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $member->member_code }}</td>
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $member->name }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $member->email }}</td>
                        <td class="py-4 px-6 text-center font-bold text-gray-600">{{ $member->active_borrowings_count }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $member->status === 'Active' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                {{ $member->status === 'Active' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center space-x-2">
                                @if($member->status === 'Active')
                                    <button @click="currentMember = {id: '{{ $member->id }}', member_code: '{{ $member->member_code }}', name: '{{ $member->name }}', email: '{{ $member->email }}', status: '{{ $member->status }}'}; openEditModal = true" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded shadow transition">
                                        Edit
                                    </button>
                                    <button @click="toggleUrl = '/admin/anggota/{{ $member->id }}/toggle-status'; toggleActionText = 'Menonaktifkan'; openToggleModal = true" class="px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-semibold rounded shadow transition">
                                        Non-Aktifkan
                                    </button>

                                @else
                                    <button @click="toggleUrl = '/admin/anggota/{{ $member->id }}/toggle-status'; toggleActionText = 'Mengaktifkan'; openToggleModal = true" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded shadow transition">
                                        Aktifkan
                                    </button>
                                    <button @click="deleteUrl = '/admin/anggota/{{ $member->id }}'; openDeleteModal = true" class="px-3 py-1.5 bg-white text-red-600 border border-red-100 hover:bg-red-50 text-xs font-semibold rounded transition">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-400">Belum ada data anggota di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="openAddModal" 
             class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto"
             style="display: none;">
            
            <div x-show="openAddModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
                 @click="openAddModal = false"></div>

            <div x-show="openAddModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-gray-100 relative z-10 my-8">
                
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">Tambah Anggota Baru</h3>
                    <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600 text-2xl transition">&times;</button>
                </div>
                <form action="{{ route('admin.anggota.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kode Anggota</label>
                        <input type="text" name="member_code" placeholder="Contoh: #USR-005" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Masukkan nama..." required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" placeholder="contoh@email.com" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Password Awal</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter..." required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="openAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">Simpan Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openEditModal" 
             class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" 
             style="display: none;">
            
            <div x-show="openEditModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
                 @click="openEditModal = false"></div>

            <div x-show="openEditModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-gray-100 relative z-10 my-8">
                
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">Edit Data Anggota</h3>
                    <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 text-2xl transition">&times;</button>
                </div>
                <form :action="'/admin/anggota/' + currentMember.id" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kode Anggota</label>
                        <input type="text" name="member_code" x-model="currentMember.member_code" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="currentMember.name" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" x-model="currentMember.email" required class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Ganti Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Isi hanya jika ingin diganti..." class="w-full text-sm bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700">
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
        <div x-show="openToggleModal" 
             class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" 
             style="display: none;">
            
            <div x-show="openToggleModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
                 @click="openToggleModal = false"></div>

            <div x-show="openToggleModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 border border-gray-100 relative z-10 text-center space-y-4 my-8">
                
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold border border-amber-100">
                    🔄
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Ubah Status Anggota?</h3>
                    <p class="text-xs text-gray-500 mt-1">Apakah Anda yakin ingin <span class="font-semibold text-gray-700" x-text="toggleActionText.toLowerCase()"></span> anggota ini?</p>
                </div>
                <form :action="toggleUrl" method="POST" class="flex justify-center space-x-2 pt-4 border-t border-gray-100">
                    @csrf
                    @method('PATCH')
                    <button type="button" @click="openToggleModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-md transition">Ya, Ubah Status</button>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="openDeleteModal" 
             class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" 
             style="display: none;">
            
            <div x-show="openDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
                 @click="openDeleteModal = false"></div>

            <div x-show="openDeleteModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 border border-gray-100 relative z-10 text-center space-y-4 my-8">
                
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold border border-red-100">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Hapus Anggota Ini?</h3>
                    <p class="text-xs text-gray-500 mt-1">Tindakan ini bersifat permanen. Semua histori transaksi sirkulasi milik user ini akan ikut terhapus otomatis.</p>
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