<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LibSpace Mahasiswa')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased flex min-h-screen">

    @include('components.member-sidebar')

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Top Sticky Header -->
        <header class="bg-white border-b border-gray-100 py-4 px-8 sticky top-0 z-20 shadow-sm/50 flex justify-between items-center">
            <div class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 select-none">
                📅 Hari Ini: <span class="font-semibold text-gray-600">{{ date('d M Y') }}</span>
            </div>
            
            <!-- PERBAIKAN UTAMA: Mengambil status dinamis dari user yang sedang login -->
            <div class="text-xs font-bold bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-lg {{ Auth::user()->status === 'Active' ? 'text-blue-600 bg-blue-50 border-blue-100' : 'text-red-600 bg-red-50 border-red-100' }}">
                Status : {{ Auth::user()->status ?? 'Unknown' }}
            </div>
        </header>

        <!-- Dynamic Content Section -->
        <div class="p-8 max-w-7xl w-full mx-auto flex-1">
            @yield('content')
        </div>
    </main>

</body>
</html>