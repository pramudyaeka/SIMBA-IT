<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | SIMBA IT</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">

    <style>
        .font-jakarta {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 font-jakarta">

    <!-- Overlay -->
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/40 hidden z-30"></div>

    <!-- MAIN AREA -->
    <div class="min-h-screen">

        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Main Content -->
        <main id="mainContent" class="ml-0 transition-all duration-300 p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>
