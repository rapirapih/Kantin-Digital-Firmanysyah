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

            @if (session('status'))
                <div class="status-banner">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="error-banner">
                    <p class="font-semibold mb-2">Validasi gagal:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Total User</p>
                            <p class="metric-value">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--info-bg);">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Penjual</p>
                            <p class="metric-value">{{ $stats['total_penjual'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--brand-soft);">
                            <svg class="w-5 h-5" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Pembeli</p>
                            <p class="metric-value">{{ $stats['total_pembeli'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Pesanan Hari Ini</p>
                            <p class="metric-value">{{ $stats['total_pesanan_hari_ini'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--warn-bg);">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Omzet Hari Ini</p>
                            <p class="metric-value text-xl sm:text-2xl">Rp {{ number_format($stats['omzet_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
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
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: linear-gradient(135deg, var(--brand) 0%, #9a3412 100%);">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-stone-800">{{ $item->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-stone-500">{{ $item->email }}</td>
                                    <td><span class="badge {{ $badge }}">{{ $item->role }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('dashboard.admin.users.role', $item) }}" class="flex gap-2 items-center">
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

            <!-- Penukaran Kode Tunai -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <div class="lg:col-span-2 panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                        Penukaran Kode Tunai
                    </h3>
                    <p class="text-sm mb-4" style="color: var(--muted);">Masukkan kode transaksi yang diberikan pembeli beserta jumlah uang yang diterima.</p>
                    <form method="POST" action="{{ route('dashboard.admin.topups.tunai') }}" class="space-y-4" x-data="{ uang: 0, jumlahTopup: 0 }">
                        @csrf
                        <div>
                            <label class="field-label">Kode Transaksi</label>
                            <input name="kode_transaksi" class="field font-mono uppercase tracking-widest text-center text-lg" placeholder="Contoh: A3F1B2C4" required maxlength="20" style="letter-spacing: 0.2em;">
                        </div>
                        <div>
                            <label class="field-label">Uang Diterima (Rp)</label>
                            <input name="uang_diterima" type="number" min="0" class="field" placeholder="Contoh: 50000" required x-model.number="uang">
                        </div>
                        <button class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Proses Penukaran
                        </button>
                    </form>
                    <div class="mt-3 text-xs text-center" style="color: var(--muted);">
                        <span class="badge-yellow text-xs">{{ $pendingTunaiCount }} kode tunai menunggu</span>
                    </div>
                </div>

                <!-- Konfirmasi Transfer -->
                <div class="lg:col-span-3 panel-section overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Konfirmasi Transfer
                        </h3>
                        <span class="badge-yellow text-xs">{{ $pendingTransfers->count() }} menunggu</span>
                    </div>

                    <div class="overflow-x-auto -mx-5 sm:-mx-6">
                        <table class="table-clean min-w-full">
                            <thead>
                                <tr>
                                    <th>Pembeli</th>
                                    <th>Jumlah</th>
                                    <th>Bukti</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingTransfers as $topup)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0" style="background: linear-gradient(135deg, var(--brand) 0%, #9a3412 100%);">
                                                    {{ strtoupper(substr($topup->user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-stone-700">{{ $topup->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format($topup->jumlah, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($topup->bukti_transfer)
                                                <a href="{{ asset('storage/' . $topup->bukti_transfer) }}" target="_blank" class="text-xs font-medium underline" style="color: var(--brand);">Lihat Bukti</a>
                                            @else
                                                <span style="color: var(--muted);">-</span>
                                            @endif
                                        </td>
                                        <td class="text-xs" style="color: var(--muted);">{{ $topup->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('dashboard.admin.topups.confirm', $topup) }}" onsubmit="return confirm('Konfirmasi top up transfer Rp {{ number_format($topup->jumlah, 0, ',', '.') }} untuk {{ $topup->user->name }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn-primary btn-sm">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p>Tidak ada transfer yang menunggu konfirmasi.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
