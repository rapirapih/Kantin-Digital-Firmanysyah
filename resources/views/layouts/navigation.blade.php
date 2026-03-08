@php $role = Auth::user()->role; @endphp

<nav x-data="{ open: false }" class="sticky top-0 z-40" style="background-color: var(--panel); border-bottom: 1px solid var(--line);">
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
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side: User + Dropdown -->
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
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, var(--brand) 0%, #9a3412 100%);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
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

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-stone-400 hover:text-stone-600 hover:bg-stone-100 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden" style="border-top: 1px solid var(--line);">
        <div class="py-2 space-y-1" style="background-color: var(--panel);">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard.pembeli') || request()->routeIs('dashboard.penjual') || request()->routeIs('dashboard.admin')">
                Dashboard
            </x-responsive-nav-link>
            @if ($role === 'pembeli')
                <x-responsive-nav-link :href="route('dashboard.pembeli.cart')" :active="request()->routeIs('dashboard.pembeli.cart')">
                    Keranjang
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard.pembeli.topup')" :active="request()->routeIs('dashboard.pembeli.topup')">
                    Top Up Saldo
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard.pembeli.riwayat')" :active="request()->routeIs('dashboard.pembeli.riwayat')">
                    Riwayat Pesanan
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                Profil
            </x-responsive-nav-link>
        </div>

        <div class="py-3 px-4" style="background-color: var(--bg); border-top: 1px solid var(--line);">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background: linear-gradient(135deg, var(--brand) 0%, #9a3412 100%);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-stone-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-stone-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                    Keluar
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
