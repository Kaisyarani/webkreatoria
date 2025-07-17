<!DOCTYPE html>
<html lang="id">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kreatoria')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* CSS Global dasar */
       @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');

        :root {
            --bg-dark: #111827;
            --bg-medium: #1F2937;
            --bg-light: #374151;
            --text-primary: #F9FAFB;
            --text-secondary: #9CA3AF;
            --accent: #22D3EE;
            --accent-dark: #0E7490;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* Style body khusus untuk layout chat */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            overflow: hidden; /* Mencegah scroll di luar app */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
    </style>
    {{-- Tempat untuk CSS spesifik dari halaman chat --}}
    @stack('styles')
</head>
<body>
    {{-- Di layout ini, <main> akan menjadi wrapper utama --}}
    <main>
        @yield('content')
    </main>

    {{-- Tempat untuk JavaScript spesifik dari halaman chat --}}
    @stack('scripts')
    @livewireScripts

</body>
</html>
