<!DOCTYPE html>
<html lang="id">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kreatoria')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* CSS Global untuk semua halaman */
       @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');

        :root {
            --bg-dark: #111827;
            --bg-medium: #1F2937;
            --bg-light: #374151;
            --text-primary: #F9FAFB;
            --text-secondary: #9CA3AF;
            --accent: #22D3EE;
            --accent-dark: #0E7490;
            --navbar-height: 88px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        a { color: inherit; text-decoration: none; }
        .footer { border-top:1px solid var(--bg-light); text-align:center; padding:40px 0; margin-top: 40px; }
        .footer p { color:var(--text-secondary); }
    </style>
    {{-- Ini adalah tempat untuk CSS spesifik per halaman --}}
    @stack('styles')
</head>
<body>
    
    {{-- Memasukkan komponen navbar universal --}}
    @include('layouts.navigation')

    <main>
        {{-- Di sinilah konten utama dari setiap halaman akan ditampilkan --}}
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container"><p>&copy; 2025 Kreatoria. Semua Hak Cipta Dilindungi.</p></div>
    </footer>

    {{-- Ini adalah tempat untuk JavaScript spesifik per halaman --}}
    @stack('scripts')
    @livewireScripts
</body>
</html>
