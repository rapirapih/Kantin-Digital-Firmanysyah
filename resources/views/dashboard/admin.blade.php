<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Admin</h1>
                    <p class="section-subtitle">Ringkasan data & kelola pengguna sistem</p>
                </div>
                <span class="badge-blue text-xs">{{ $today }}</span>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Total User</p>
                            <p class="metric-value">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--info-bg);">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Penjual</p>
                            <p class="metric-value">{{ $stats['total_penjual'] }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--brand-soft);">
                            <svg class="w-4 h-4" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Pembeli</p>
                            <p class="metric-value">{{ $stats['total_pembeli'] }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--accent-soft);">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Pesanan Hari Ini</p>
                            <p class="metric-value">{{ $stats['total_pesanan_hari_ini'] }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--warn-bg);">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Omzet Hari Ini</p>
                            <p class="metric-value text-lg">Rp {{ number_format($stats['omzet_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--accent-soft);">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="metric-label">Potongan WD</p>
                            <p class="metric-value text-lg">Rp {{ number_format($stats['potongan_withdrawal_total'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--brand-soft);">
                            <svg class="w-4 h-4" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] mt-1" style="color: var(--muted);">10% dari setiap penarikan</p>
                </div>
            </div>

            <!-- Quick Access Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('dashboard.admin.penukaran') }}" class="panel-section hover:shadow-md transition-shadow group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: var(--warn-bg);">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-stone-800 group-hover:text-orange-600 transition-colors">Penukaran</p>
                            <p class="text-xs" style="color: var(--muted);">
                                {{ $pendingTunaiCount + $pendingTransfers + $pendingWithdrawals }} menunggu konfirmasi
                            </p>
                        </div>
                        <svg class="w-5 h-5" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('dashboard.admin.kategori') }}" class="panel-section hover:shadow-md transition-shadow group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: var(--brand-soft);">
                            <svg class="w-6 h-6" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-stone-800 group-hover:text-orange-600 transition-colors">Kategori</p>
                            <p class="text-xs" style="color: var(--muted);">Kelola kategori menu</p>
                        </div>
                        <svg class="w-5 h-5" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('dashboard.admin.laporan') }}" class="panel-section hover:shadow-md transition-shadow group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-stone-800 group-hover:text-orange-600 transition-colors">Laporan</p>
                            <p class="text-xs" style="color: var(--muted);">Laporan per penjual</p>
                        </div>
                        <svg class="w-5 h-5" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>

            <!-- Buat Akun Penjual -->
            <div class="panel-section" x-data="{ open: false }">
                <div class="flex items-center justify-between">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Buat Akun Penjual
                    </h3>
                    <button @click="open = !open" class="btn-secondary btn-sm text-xs" x-text="open ? 'Tutup' : 'Tambah Penjual'"></button>
                </div>

                <div x-show="open" x-cloak x-transition class="mt-4">
                    <form method="POST" action="{{ route('dashboard.admin.penjual.store', [], false) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @csrf
                        <div>
                            <label for="penjual_name" class="field-label">Nama</label>
                            <input id="penjual_name" name="name" type="text" class="field" required placeholder="Nama penjual" value="{{ old('name') }}" />
                            <x-input-error class="mt-1" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <label for="penjual_email" class="field-label">Email</label>
                            <input id="penjual_email" name="email" type="email" class="field" required placeholder="email@contoh.com" value="{{ old('email') }}" />
                            <x-input-error class="mt-1" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <label for="penjual_password" class="field-label">Password</label>
                            <div class="flex gap-2">
                                <input id="penjual_password" name="password" type="text" class="field flex-1" required placeholder="Min. 6 karakter" />
                                <button type="submit" class="btn-primary btn-sm shrink-0">Buat</button>
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('password')" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Management -->
            <div class="panel-section overflow-hidden">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Manajemen Role User
                    </h3>
                    <span class="badge-gray text-xs">{{ $users->count() }} pengguna</span>
                </div>

                <div class="overflow-x-auto -mx-5 sm:-mx-6">
                    <table class="table-clean min-w-full">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                @php
                                    $badge = match($item->role) {
                                        'admin' => 'badge-blue',
                                        'penjual' => 'badge-orange',
                                        'pembeli' => 'badge-green',
                                        default => 'badge-gray',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-stone-800">{{ $item->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-stone-500">{{ $item->email }}</td>
                                    <td><span class="badge {{ $badge }}">{{ $item->role }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('dashboard.admin.users.role', $item, false) }}" class="flex gap-2 items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="field text-xs !w-28 !py-1.5 !rounded-lg">
                                                <option value="admin" @selected($item->role === 'admin')>admin</option>
                                                <option value="penjual" @selected($item->role === 'penjual')>penjual</option>
                                                <option value="pembeli" @selected($item->role === 'pembeli')>pembeli</option>
                                            </select>
                                            <button class="btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
