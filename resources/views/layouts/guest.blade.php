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

        <style>
            .auth-page { display: flex; min-height: 100vh; min-height: 100dvh; }
            .auth-brand { display: none; }
            .auth-form-side { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem 1.5rem; overflow-y: auto; background: #f9fafb; }

            @media (min-width: 1024px) {
                .auth-page { height: 100vh; height: 100dvh; overflow: hidden; }
                .auth-brand {
                    display: flex; width: 480px; flex-shrink: 0; align-items: center; justify-content: center;
                    background: linear-gradient(160deg, #C62828 0%, #8E0000 60%, #5D0000 100%);
                    position: relative; overflow: hidden;
                }
                .auth-form-side { overflow-y: auto; }
            }

            .auth-decor-1 { position: absolute; top: -80px; right: -60px; width: 280px; height: 280px; border-radius: 50%; background: rgba(255,214,0,0.1); }
            .auth-decor-2 { position: absolute; bottom: -60px; left: -40px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.05); }
            .auth-decor-3 { position: absolute; top: 50%; left: -20px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,214,0,0.06); }

            .auth-card {
                width: 100%; max-width: 420px;
                background: #fff; border-radius: 1.25rem; padding: 2rem 1.75rem;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 6px 24px rgba(0,0,0,0.06);
            }

            .auth-input {
                width: 100%; padding: 0.65rem 0.875rem; font-size: 0.875rem;
                border: 1.5px solid #e5e7eb; border-radius: 0.75rem; outline: none;
                transition: border-color 0.2s, box-shadow 0.2s; background: #fff;
            }
            .auth-input:focus { border-color: #C62828; box-shadow: 0 0 0 3px rgba(198,40,40,0.08); }
            .auth-input::placeholder { color: #9ca3af; }

            .auth-label { display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem; }

            .auth-btn {
                width: 100%; padding: 0.75rem; font-size: 0.875rem; font-weight: 600;
                color: #fff; background: #C62828; border: none; border-radius: 0.75rem; cursor: pointer;
                transition: background 0.2s, transform 0.1s;
            }
            .auth-btn:hover { background: #a51c1c; }
            .auth-btn:active { transform: scale(0.985); }
        </style>
    </head>
    <body class="antialiased" style="font-family: 'Poppins', sans-serif;">
        <div class="auth-page">
            {{-- Left brand panel (desktop only) --}}
            <div class="auth-brand">
                <div class="auth-decor-1"></div>
                <div class="auth-decor-2"></div>
                <div class="auth-decor-3"></div>

                <div style="position: relative; z-index: 1; padding: 0 3rem; max-width: 380px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2.5rem;">
                        <img src="{{ asset('images/Logo_SMK_Negeri_40_Jakarta.png') }}" alt="Logo" style="width: 44px; height: 44px; border-radius: 12px; object-fit: contain;">
                        <span style="font-size: 1.375rem; font-weight: 700; color: #fff;">E-MPU Store</span>
                    </div>

                    <h1 style="font-size: 2rem; font-weight: 700; line-height: 1.2; color: #fff; margin-bottom: 0.75rem;">
                        Pesan makanan kantin tanpa antre
                    </h1>
                    <p style="font-size: 0.9375rem; line-height: 1.7; color: rgba(255,255,255,0.7);">
                        Sistem pre-order kantin digital untuk siswa & guru SMK Negeri 40 Jakarta.
                    </p>

                    <div style="display: flex; justify-content: space-between; margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.12);">
                        <div style="text-align: center; flex: 1;">
                            <div style="font-size: 1.75rem; font-weight: 700; color: #fff;">3</div>
                            <div style="font-size: 0.6875rem; color: #FFD600; margin-top: 0.25rem; white-space: nowrap;">Role Pengguna</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="font-size: 1.75rem; font-weight: 700; color: #fff;">2</div>
                            <div style="font-size: 0.6875rem; color: #FFD600; margin-top: 0.25rem; white-space: nowrap;">Sesi Istirahat</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="font-size: 1.75rem; font-weight: 700; color: #fff;">1</div>
                            <div style="font-size: 0.6875rem; color: #FFD600; margin-top: 0.25rem; white-space: nowrap;">Sekolah</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="auth-form-side">
                <div style="width: 100%; max-width: 420px;">
                    {{-- Mobile logo --}}
                    <div class="lg:hidden" style="text-align: center; margin-bottom: 2rem;">
                        <a href="/" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                            <img src="{{ asset('images/Logo_SMK_Negeri_40_Jakarta.png') }}" alt="Logo" style="width: 36px; height: 36px; border-radius: 10px; object-fit: contain;">
                            <span style="font-size: 1.125rem; font-weight: 700; color: #1f2937;">E-MPU Store</span>
                        </a>
                    </div>

                    <div class="auth-card">
                        {{ $slot }}
                    </div>

                    <p style="text-align: center; font-size: 0.6875rem; color: #9ca3af; margin-top: 1.5rem;">
                        &copy; {{ date('Y') }} E-MPU Store &mdash; SMK Negeri 40 Jakarta
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
