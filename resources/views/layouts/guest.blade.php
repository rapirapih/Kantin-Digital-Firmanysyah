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
        <div class="page-shell flex min-h-screen">
            <!-- Brand Panel -->
            <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center" style="background: linear-gradient(135deg, #ea580c 0%, #9a3412 100%);">
                <div class="relative z-10 px-12 text-white max-w-lg">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Kantin Digital</span>
                    </div>

                    <h1 class="text-4xl font-bold leading-tight mb-4 text-white">Pesan makanan sekolah jadi lebih mudah</h1>
                    <p class="text-orange-100 text-lg leading-relaxed">Sistem pre-order kantin sekolah yang memudahkan siswa, guru, dan penjual.</p>

                    <div class="mt-10 grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-3xl font-bold">3</div>
                            <div class="text-orange-200 text-sm mt-1">Role Pengguna</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">2</div>
                            <div class="text-orange-200 text-sm mt-1">Sesi Istirahat</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">&infin;</div>
                            <div class="text-orange-200 text-sm mt-1">Menu Variatif</div>
                        </div>
                    </div>
                </div>
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-white/5" style="transform: translate(30%, -30%);"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-white/5" style="transform: translate(-30%, 30%);"></div>
            </div>

            <!-- Form Panel -->
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-10">
                <div class="w-full max-w-md">
                    <div class="lg:hidden mb-8 text-center">
                        <a href="/" class="inline-flex">
                            <x-application-logo />
                        </a>
                    </div>

                    <div class="panel p-6 sm:p-8">
                        {{ $slot }}
                    </div>

                    <p class="text-center text-xs mt-6" style="color: var(--muted);">
                        &copy; {{ date('Y') }} Kantin Digital &mdash; E-Canteen System
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
