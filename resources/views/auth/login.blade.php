<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LibSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center space-y-2 select-none">
        <span class="text-4xl">🎓</span>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Sistem Perpustakaan LibSpace</h2>
        <p class="text-sm text-gray-500">Silakan masukkan akun Anda untuk mengakses katalog dan layanan sirkulasi.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-2xl border border-gray-100 shadow-xl space-y-6">
            
            <!-- HANDLING ALERT ERROR LOG IN -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex justify-between items-center text-xs text-red-700 animate-fade-in" x-data="{}">
                    <span>⚠️ {{ session('error') }}</span>
                    <button class="font-bold hover:text-red-900" @click="$el.parentElement.remove()">&times;</button>
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex justify-between items-center text-xs text-green-700 animate-fade-in" x-data="{}">
                    <span>✅ {{ session('success') }}</span>
                    <button class="font-bold hover:text-green-900" @click="$el.parentElement.remove()">&times;</button>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat Email</label>
                    <input type="email" name="email" required placeholder="khaikal@admin.com / diva@example.com" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div class="flex items-center justify-between pt-1 text-xs">
                    <label class="inline-flex items-center space-x-2 text-gray-500 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span>Ingat Saya di Perangkat Ini</span>
                    </label>
                    <span class="text-gray-400 italic">Edisi Tugas Akhir TRPL</span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md text-sm transition duration-200">
                        Masuk Dashboard 🚀
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>