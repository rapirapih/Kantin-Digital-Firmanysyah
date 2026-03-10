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

            {{-- Modal Kode Penukaran --}}
            @if (session('withdrawal_kode'))
                <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" style="display: none; padding: 16px;">
                    <div class="absolute inset-0" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);" @click="open = false"></div>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="relative"
                         style="background: #ffffff; border-radius: 16px; width: 380px; max-width: calc(100vw - 32px); box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(0,0,0,0.06);">

                        <div style="height: 4px; background: linear-gradient(90deg, #059669, #10b981, #34d399); border-radius: 16px 16px 0 0;"></div>

                        <div style="padding: 28px 28px 24px; text-align: center;">
                            <div style="width: 56px; height: 56px; border-radius: 50%; background: #ecfdf5; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg style="width: 28px; height: 28px; color: #059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>

                            <h3 style="font-size: 18px; font-weight: 700; color: #1c1917; margin: 0 0 4px;">Penukaran Berhasil!</h3>
                            <p style="font-size: 13px; color: #78716c; margin: 0 0 20px;">Tunjukkan kode ini ke admin untuk menerima uang tunai</p>

                            <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 16px; margin-bottom: 16px;">
                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin-bottom: 6px;">Kode Penukaran</div>
                                <div style="font-size: 32px; font-weight: 800; letter-spacing: 0.15em; color: #0f172a; font-family: ui-monospace, monospace;">{{ session('withdrawal_kode') }}</div>
                            </div>

                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
                                <div style="font-size: 11px; font-weight: 600; color: #16a34a; margin-bottom: 2px;">Jumlah Penukaran</div>
                                <div style="font-size: 22px; font-weight: 800; color: #15803d;">Rp {{ number_format(session('withdrawal_jumlah'), 0, ',', '.') }}</div>
                            </div>

                            <button type="button" @click="open = false"
                                    style="width: 100%; padding: 12px 0; font-size: 14px; font-weight: 600; color: #fff; background: #059669; border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 2px 8px rgba(5,150,105,0.3); transition: all 0.15s;"
                                    onmouseover="this.style.background='#047857'"
                                    onmouseout="this.style.background='#059669'">
                                Mengerti
                            </button>
                        </div>
                    </div>
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
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="metric-card col-span-2 md:col-span-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Saldo Saya</p>
                            <p class="metric-value text-lg">Rp {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

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
                                <input name="nama" value="{{ $menu->nama }}" class="field text-xs w-full sm:!w-32 !py-1.5" required>
                                <input name="harga" type="number" min="0" value="{{ (float) $menu->harga }}" class="field text-xs w-full sm:!w-24 !py-1.5" required>
                                <input name="stok" type="number" min="0" value="{{ $menu->stok }}" class="field text-xs w-full sm:!w-20 !py-1.5" placeholder="Stok" required>
                                <input name="foto" type="file" accept="image/*" class="field text-xs w-full sm:!w-36 !py-1.5">
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

            <!-- Tukar Saldo & Riwayat Penukaran -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Tukar Saldo Form -->
                <div class="lg:col-span-2 panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Tukar Saldo ke Uang Tunai
                    </h3>
                    <p class="text-sm mb-4" style="color: var(--muted);">Tukarkan saldo Anda menjadi uang tunai. Anda akan mendapat kode penukaran yang bisa ditunjukkan ke admin.</p>
                    <form method="POST" action="{{ route('dashboard.penjual.withdrawal.store') }}" class="space-y-4"
                          x-data="{ showModal: false, confirmed: false, jumlah: '' }"
                          @submit.prevent="if (confirmed) { confirmed = false; $el.submit(); } else { showModal = true; }">
                        @csrf
                        <div>
                            <label class="field-label">Saldo Tersedia</label>
                            <p class="text-lg font-bold" style="color: var(--accent);">Rp {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="field-label">Jumlah Penukaran (Rp)</label>
                            <input name="jumlah" type="number" min="1000" max="{{ (float) auth()->user()->saldo }}" placeholder="Contoh: 50000" class="field" required x-model="jumlah">
                        </div>
                        <button type="submit" class="btn-primary w-full" {{ (float) auth()->user()->saldo < 1000 ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Tukar Saldo
                        </button>

                        <!-- Custom Confirmation Modal -->
                        <template x-teleport="body">
                            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" style="display: none; padding: 16px;">
                                <!-- Backdrop -->
                                <div class="absolute inset-0" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);" @click="showModal = false"></div>

                                <!-- Modal Box -->
                                <div x-show="showModal"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-90"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-90"
                                     class="relative"
                                     style="background: #ffffff; border-radius: 16px; width: 340px; max-width: calc(100vw - 32px); box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(0,0,0,0.06);">

                                    <!-- Red top stripe -->
                                    <div style="height: 4px; background: linear-gradient(90deg, #b91c1c, #dc2626, #ef4444); border-radius: 16px 16px 0 0;"></div>

                                    <!-- Body -->
                                    <div style="padding: 24px 24px 20px;">
                                        <!-- Icon circle -->
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #fef2f2; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                            <svg style="width: 22px; height: 22px; color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>

                                        <!-- Title -->
                                        <h3 style="font-size: 16px; font-weight: 700; color: #1c1917; text-align: center; margin: 0 0 4px;">Tukar Saldo?</h3>
                                        <p style="font-size: 13px; color: #78716c; text-align: center; margin: 0 0 16px;">Saldo akan dipotong dan tidak bisa dikembalikan</p>

                                        <!-- Amount box -->
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 16px; text-align: center; margin-bottom: 12px;">
                                            <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #16a34a; margin-bottom: 2px;">Jumlah</div>
                                            <div style="font-size: 26px; font-weight: 800; color: #15803d;">Rp <span x-text="Number(jumlah || 0).toLocaleString('id-ID')"></span></div>
                                        </div>

                                        <!-- Info -->
                                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 8px 10px; display: flex; align-items: flex-start; gap: 6px;">
                                            <svg style="width: 14px; height: 14px; color: #d97706; flex-shrink: 0; margin-top: 1px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span style="font-size: 11px; line-height: 1.4; color: #92400e;">Tunjukkan kode penukaran ke admin untuk terima uang tunai.</span>
                                        </div>
                                    </div>

                                    <!-- Divider -->
                                    <div style="height: 1px; background: #e7e5e4;"></div>

                                    <!-- Buttons -->
                                    <div style="display: flex; padding: 14px 24px 18px; gap: 10px;">
                                        <button type="button" @click="showModal = false"
                                                style="flex: 1; padding: 10px 0; font-size: 13px; font-weight: 600; color: #57534e; background: #ffffff; border: 2px solid #d6d3d1; border-radius: 10px; cursor: pointer; transition: all 0.15s;"
                                                onmouseover="this.style.background='#f5f5f4';this.style.borderColor='#a8a29e'"
                                                onmouseout="this.style.background='#ffffff';this.style.borderColor='#d6d3d1'">
                                            Batal
                                        </button>
                                        <button type="button" @click="showModal = false; confirmed = true; $nextTick(() => { $root.requestSubmit(); })"
                                                style="flex: 1; padding: 10px 0; font-size: 13px; font-weight: 600; color: #fff; background: #dc2626; border: 2px solid #dc2626; border-radius: 10px; cursor: pointer; box-shadow: 0 2px 8px rgba(220,38,38,0.35); transition: all 0.15s; display: inline-flex; align-items: center; justify-content: center; gap: 5px;"
                                                onmouseover="this.style.background='#b91c1c';this.style.borderColor='#b91c1c'"
                                                onmouseout="this.style.background='#dc2626';this.style.borderColor='#dc2626'">
                                            <svg style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            Ya, Tukarkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </form>
                </div>

                <!-- Riwayat Penukaran -->
                <div class="lg:col-span-3 panel-section overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Riwayat Penukaran Saldo
                        </h3>
                    </div>

                    <div class="overflow-x-auto -mx-5 sm:-mx-6">
                        <table class="table-clean min-w-full">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Kode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdrawals as $wd)
                                    <tr>
                                        <td class="text-xs" style="color: var(--muted);">{{ $wd->created_at->format('d M Y, H:i') }}</td>
                                        <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</td>
                                        <td><span class="font-mono text-xs tracking-widest font-bold">{{ $wd->kode_penukaran }}</span></td>
                                        <td>
                                            <span class="badge {{ $wd->status === 'berhasil' ? 'badge-green' : 'badge-yellow' }}">{{ $wd->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                <p>Belum ada riwayat penukaran saldo.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
