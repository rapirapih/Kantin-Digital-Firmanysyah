<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-MPU Store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="page-shell flex min-h-screen">
            <!-- Brand Panel -->
            <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                <div class="relative z-10 px-12 text-white max-w-lg">
                    <div class="flex items-center gap-3 mb-8">
                        <img src="{{ asset('images/Logo_SMK_Negeri_40_Jakarta.png') }}" alt="Logo SMK Negeri 40 Jakarta" class="w-12 h-12 rounded-xl object-contain">
                        <span class="text-2xl font-bold">E-MPU Store</span>
                    </div>

                    <h1 class="text-4xl font-bold leading-tight mb-4 text-white">Pesan makanan sekolah jadi lebih mudah</h1>
                    <p class="text-lg leading-relaxed text-red-200">Sistem pre-order kantin sekolah yang memudahkan siswa, guru, dan penjual.</p>

                    <div class="mt-10 grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-3xl font-bold">3</div>
                            <div class="text-sm mt-1 text-[#FFD600]">Role Pengguna</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">2</div>
                            <div class="text-sm mt-1 text-[#FFD600]">Sesi Istirahat</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">&infin;</div>
                            <div class="text-sm mt-1 text-[#FFD600]">Menu Variatif</div>
                        </div>
                    </div>
                </div>
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full" style="background: rgba(255,214,0,0.12); transform: translate(30%, -30%);"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full" style="background: rgba(255,214,0,0.08); transform: translate(-30%, 30%);"></div>
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
                        &copy; {{ date('Y') }} E-MPU Store &mdash; SMK Negeri 40 Jakarta
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
