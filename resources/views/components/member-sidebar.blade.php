<!-- Navigasi Sidebar Khusus Mahasiswa / Anggota -->
<div class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between h-screen sticky top-0 shadow-sm">
    <div class="p-6 space-y-8">
        <!-- Logo Aplikasi -->
        <div class="flex items-center space-x-3 px-2 select-none">
            <span class="text-2xl">🎓</span>
            <div class="flex flex-col">
                <span class="font-extrabold text-gray-800 text-lg tracking-tight">LibSpace</span>
                <span class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">Area Mahasiswa</span>
            </div>
        </div>

        <!-- Menu Navigasi Utama -->
        <nav class="space-y-1.5">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-2">Layanan Mandiri</p>
            
            <!-- Link ke Dashboard Katalog -->
            <a href="{{ route('member.dashboard') }}" 
               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition duration-200 {{ Route::is('member.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="text-base">📚</span>
                <span>Katalog Buku</span>
            </a>

            <!-- Link ke Riwayat Sirkulasi Personal -->
            <a href="{{ route('member.history') }}" 
               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition duration-200 {{ Route::is('member.history') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="text-base">⏱️</span>
                <span>Riwayat Pinjam</span>
            </a>
        </nav>
    </div>

    <!-- INFORMASI AKUN PERSONAL MAHASISWA & TOMBOL LOGOUT -->
    <div class="p-4 border-t border-gray-50 bg-gray-50/50 flex items-center justify-between">
        <div class="flex items-center space-x-2.5 truncate">
            <!-- Avatar inisial huruf pertama dari nama user yang login -->
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm uppercase select-none">
                {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
            </div>
            <div class="flex flex-col truncate">
                <!-- Nama dan kode member diambil dinamis dari database -->
                <span class="text-xs font-bold text-gray-800 truncate" title="{{ Auth::user()->name ?? 'Mahasiswa' }}">
                    {{ Auth::user()->name ?? 'Mahasiswa' }}
                </span>
                <span class="text-[10px] text-gray-400 font-medium">
                    {{ Auth::user()->member_code ?? '#USR-000' }}
                </span>
            </div>
        </div>
        
        <!-- Form POST Logout untuk mengamankan session mahasiswa -->
        <form action="{{ route('logout') }}" method="POST" class="flex items-center">
            @csrf
            <button 
                type="submit" 
                class="text-sm font-medium text-gray-400 hover:text-red-600 transition p-1.5 hover:bg-red-50 rounded-lg" 
                title="Log Keluar Akun"
            >
                Logout
            </button>
        </form>
    </div>
</div>