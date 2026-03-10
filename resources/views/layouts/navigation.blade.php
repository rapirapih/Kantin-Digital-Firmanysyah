@php $role = Auth::user()->role; @endphp

<nav class="sticky top-0 z-40 overflow-visible" style="background-color: var(--panel); border-bottom: 1px solid var(--line);">
    <div class="content-wrap">
        <div class="flex justify-between h-16">
            <!-- Logo + Nav Links -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="shrink-0">
                    <x-application-logo />
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard.pembeli') || request()->routeIs('dashboard.penjual') || request()->routeIs('dashboard.admin')">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                        Dashboard
                    </x-nav-link>
                    @if ($role === 'pembeli')
                        <x-nav-link :href="route('dashboard.pembeli.cart')" :active="request()->routeIs('dashboard.pembeli.cart')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            Keranjang
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.pembeli.topup')" :active="request()->routeIs('dashboard.pembeli.topup')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Top Up
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.pembeli.riwayat')" :active="request()->routeIs('dashboard.pembeli.riwayat')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Riwayat
                        </x-nav-link>
                    @endif
                    @if ($role === 'penjual')
                        <x-nav-link :href="route('dashboard.penjual.statistik')" :active="request()->routeIs('dashboard.penjual.statistik')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Statistik
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.penjual.menu')" :active="request()->routeIs('dashboard.penjual.menu')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Kelola Menu
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.penjual.tarik-tunai')" :active="request()->routeIs('dashboard.penjual.tarik-tunai')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Tarik Tunai
                        </x-nav-link>
                    @endif
                    @if ($role === 'admin')
                        <x-nav-link :href="route('dashboard.admin.penukaran')" :active="request()->routeIs('dashboard.admin.penukaran')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                            Penukaran
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.admin.kategori')" :active="request()->routeIs('dashboard.admin.kategori')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Kategori
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.admin.laporan')" :active="request()->routeIs('dashboard.admin.laporan')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Laporan
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side: User + Dropdown (desktop) -->
            <div class="hidden sm:flex items-center gap-3">
                @php
                    $roleBadge = match($role) {
                        'admin' => 'badge-blue',
                        'penjual' => 'badge-orange',
                        'pembeli' => 'badge-green',
                        default => 'badge-gray',
                    };
                @endphp

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm transition-colors duration-150 hover:bg-stone-50">
                            <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                                @if (Auth::user()->foto_profile)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" class="w-full h-full object-cover" />
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="text-left">
                                <div class="font-medium text-stone-800 text-sm leading-tight">{{ Auth::user()->name }}</div>
                                <span class="badge {{ $roleBadge }} text-[10px] px-1.5 py-0">{{ $role }}</span>
                            </div>
                            <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile: Profile Icon + Dropdown -->
            <div class="relative flex items-center sm:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="w-9 h-9 rounded-full overflow-hidden flex items-center justify-center text-white text-xs font-bold focus:outline-none focus:ring-2 focus:ring-offset-1" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%); --tw-ring-color: var(--brand);">
                    @if (Auth::user()->foto_profile)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" class="w-full h-full object-cover" />
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </button>

                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 top-full mt-2 w-44 rounded-xl shadow-lg ring-1 ring-black/5 py-1 z-[999]"
                     style="background-color: var(--panel);"
                     x-cloak>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors" style="color: var(--foreground);" onmouseover="this.style.backgroundColor='var(--accent-soft)'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg class="w-4 h-4" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left transition-colors" style="color: #dc2626;" onmouseover="this.style.backgroundColor='var(--accent-soft)'" onmouseout="this.style.backgroundColor='transparent'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
