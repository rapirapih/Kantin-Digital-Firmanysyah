<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Penjual</h1>
                    <p class="section-subtitle">Kelola menu & pesanan kantin Anda</p>
                </div>
                <span class="badge-orange text-xs">{{ $today }}</span>
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
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Menu Saya</p>
                            <p class="metric-value">{{ $stats['total_menu_saya'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--brand-soft);">
                            <svg class="w-5 h-5" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Menunggu</p>
                            <p class="metric-value">{{ $stats['menunggu'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--warn-bg);">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Diproses</p>
                            <p class="metric-value">{{ $stats['diproses'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--info-bg);">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Selesai</p>
                            <p class="metric-value">{{ $stats['selesai'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--ok-bg);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Management -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Add Menu Form -->
                <div class="lg:col-span-2 panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Menu Baru
                    </h3>
                    <form method="POST" action="{{ route('dashboard.penjual.menus.store') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="field-label">Nama Menu</label>
                            <input name="nama" placeholder="Contoh: Nasi Goreng Spesial" class="field" required>
                        </div>
                        <div>
                            <label class="field-label">Harga (Rp)</label>
                            <input name="harga" type="number" min="0" placeholder="10000" class="field" required>
                        </div>
                        <div>
                            <label class="field-label">Stok</label>
                            <input name="stok" type="number" min="0" placeholder="50" class="field" required>
                        </div>
                        <div>
                            <label class="field-label">Foto (opsional)</label>
                            <input name="foto" type="file" accept="image/*" class="field">
                        </div>
                        <button class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Simpan Menu
                        </button>
                    </form>
                </div>

                <!-- Menu List -->
                <div class="lg:col-span-3 panel-section overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Kelola Menu Saya
                        </h3>
                        <span class="badge-gray text-xs">{{ $menus->count() }} menu</span>
                    </div>

                    @forelse ($menus as $menu)
                        <div class="py-3 {{ !$loop->last ? 'border-b' : '' }}" style="border-color: var(--line-light);">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-stone-800">{{ $menu->nama }}</span>
                                        <span class="badge {{ $menu->stok > 0 ? 'badge-green' : 'badge-red' }}">Stok: {{ $menu->stok }}</span>
                                    </div>
                                    <span class="text-sm font-semibold" style="color: var(--brand);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                </div>
                                <form method="POST" action="{{ route('dashboard.penjual.menus.delete', $menu) }}" onsubmit="return confirm('Hapus menu ini?')" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger btn-sm">
                                        <svg class="w-3 h-3 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            <form method="POST" action="{{ route('dashboard.penjual.menus.update', $menu) }}" class="mt-2 flex flex-wrap gap-2 items-end" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input name="nama" value="{{ $menu->nama }}" class="field text-xs !w-32 !py-1.5" required>
                                <input name="harga" type="number" min="0" value="{{ (float) $menu->harga }}" class="field text-xs !w-24 !py-1.5" required>
                                <input name="stok" type="number" min="0" value="{{ $menu->stok }}" class="field text-xs !w-20 !py-1.5" placeholder="Stok" required>
                                <input name="foto" type="file" accept="image/*" class="field text-xs !w-36 !py-1.5">
                                <button class="btn-primary btn-sm">Update</button>
                            </form>
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <p>Belum ada menu. Tambah menu pertamamu!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Order Queue -->
            <div class="panel-section overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Antrean Pesanan
                    </h3>

                    <form method="GET" action="{{ route('dashboard.penjual') }}" class="flex items-center gap-2">
                        <select name="waktu_ambil" class="field text-xs !w-36 !py-1.5 !rounded-lg">
                            <option value="istirahat_1" @selected($selected_waktu_ambil === 'istirahat_1')>Istirahat 1</option>
                            <option value="istirahat_2" @selected($selected_waktu_ambil === 'istirahat_2')>Istirahat 2</option>
                        </select>
                        <button class="btn-secondary btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto -mx-5 sm:-mx-6">
                    <table class="table-clean min-w-full">
                        <thead>
                            <tr>
                                <th>Pembeli</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($queue as $order)
                                @php
                                    $statusBadge = match($order->status_pesanan) {
                                        'menunggu' => 'badge-yellow',
                                        'diproses' => 'badge-blue',
                                        'selesai' => 'badge-green',
                                        'dibatalkan' => 'badge-red',
                                        default => 'badge-gray',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-stone-700">{{ $order->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $order->menu->nama }}</td>
                                    <td><span class="font-semibold">{{ $order->jumlah }}</span></td>
                                    <td><span class="badge {{ $statusBadge }}">{{ $order->status_pesanan }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('dashboard.penjual.orders.status', $order) }}" class="flex gap-2 items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_pesanan" class="field text-xs !w-28 !py-1.5 !rounded-lg">
                                                <option value="diproses" @selected($order->status_pesanan === 'diproses')>Diproses</option>
                                                <option value="selesai" @selected($order->status_pesanan === 'selesai')>Selesai</option>
                                                <option value="dibatalkan" @selected($order->status_pesanan === 'dibatalkan')>Dibatalkan</option>
                                            </select>
                                            <button class="btn-primary btn-sm">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <p>Belum ada antrean untuk sesi ini.</p>
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
</x-app-layout>
