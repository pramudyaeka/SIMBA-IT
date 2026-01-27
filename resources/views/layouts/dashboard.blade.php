<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SIMBA IT</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        .font-jakarta {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 font-jakarta text-slate-600">

    @include('layouts.sidebar')

    <div id="overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-30 transition-opacity opacity-0 lg:hidden">
    </div>

    <div class="transition-all duration-300 lg:ml-72 min-h-screen flex flex-col">

        @include('layouts.navbar')

        <div
            class="lg:hidden flex items-center justify-between p-4 bg-white border-b border-slate-200 sticky top-0 z-20">
            <div class="flex items-center gap-2">
                <div class="size-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">S
                </div>
                <span class="font-bold text-slate-800">SIMBA IT</span>
            </div>
            <button onclick="toggleSidebar()" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <main class="flex-1">
            @yield('content')
        </main>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            // Toggle Translate Sidebar
            if (sidebar.classList.contains('-translate-x-full')) {
                // Buka Sidebar
                sidebar.classList.remove('-translate-x-full');

                // Tampilkan Overlay
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10); // delay sedikit agar transisi opacity jalan
            } else {
                // Tutup Sidebar
                sidebar.classList.add('-translate-x-full');

                // Sembunyikan Overlay
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300); // sesuaikan dengan duration-300
            }
        }
    </script>

</body>

</html>