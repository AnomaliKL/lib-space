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
    <div class="p-5 border-t border-slate-700">
        <p class="text-sm text-slate-400">Login sebagai: <span class="text-slate-200 font-semibold">Admin</span></p>
    </div>
</aside>