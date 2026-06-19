<aside class="w-64 bg-slate-800 text-slate-100 h-full flex flex-col justify-between hidden md:flex">
    <div class="p-5">
        <h2 class="text-2xl font-bold tracking-wider text-blue-400 mb-8">LibSpace</h2>
        <nav class="space-y-2">
            <a href="/admin" class="block py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Dashboard
            </a>
            
            <a href="/admin/katalog" class="block py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin/katalog') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Katalog Buku
            </a>
            
            <a href="/admin/peminjaman" class="block py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin/peminjaman') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Peminjaman
            </a>
            
            <a href="/admin/pengembalian" class="block py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin/pengembalian') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Pengembalian
            </a>
            
            <a href="/admin/anggota" class="block py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin/anggota') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Data Anggota
            </a>
        </nav>
    </div>

    <!-- BAGIAN YANG DIPERBARUI: FOOTER SIDEBAR DENGAN TOMBOL LOGOUT AMAN -->
    <div class="p-5 border-t border-slate-700 bg-slate-900/30 space-y-3">
        <div class="flex flex-col">
            <p class="text-xs text-slate-400">Login sebagai:</p>
            <!-- Menggunakan data dinamis admin yang sedang login -->
            <p class="text-sm text-blue-400 font-bold truncate">{{ Auth::user()->name ?? 'Admin Utama' }}</p>
        </div>

        <!-- Form POST Logout untuk mengamankan token CSRF Session -->
        <form action="{{ route('logout') }}" method="POST" class="pt-1">
            @csrf
            <button 
                type="submit" 
                class="w-full text-center py-2 px-4 bg-red-600/80 hover:bg-red-600 text-white text-xs font-bold rounded transition duration-200 shadow-sm flex items-center justify-center space-x-2"
            >
                <span>🚪</span>
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</aside>