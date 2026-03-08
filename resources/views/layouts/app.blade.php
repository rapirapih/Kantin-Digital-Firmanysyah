<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kantin Digital') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="page-shell">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="pb-12">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="content-wrap py-6 border-t" style="border-color: var(--line);">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs" style="color: var(--muted);">
                    <span>&copy; {{ date('Y') }} Kantin Digital &mdash; E-Canteen System</span>
                    <span>Sistem pre-order makanan sekolah</span>
                </div>
            </footer>
        </div>
    </body>
</html>
