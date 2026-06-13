<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LibSpace')</title>
    @vite('resources/css/app.css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    @include('components.sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        @include('components.navbar')

        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

</body>
</html>