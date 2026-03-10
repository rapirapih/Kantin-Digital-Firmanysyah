<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard Penjual</h1>
                    <p class="section-subtitle">Kelola pesanan kantin Anda</p>
                </div>
                <span class="badge-orange text-xs">{{ $today }}</span>
            </div>



            <!-- Saldo Card + Order Notification -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Saldo Saya</p>
                            <p class="metric-value text-lg">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                @if ($newOrdersCount > 0)
                    <div class="metric-card" style="border-left: 4px solid var(--brand); animation: pulse-notif 2s infinite;">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="metric-label">Pesanan Baru!</p>
                                <p class="metric-value text-lg" style="color: var(--brand);">{{ $newOrdersCount }} pesanan menunggu</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--warn-bg);">
                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="metric-card">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="metric-label">Pesanan Baru</p>
                                <p class="metric-value text-lg" style="color: var(--muted);">Tidak ada</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--ok-bg);">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Queue -->
            <div class="panel-section overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Antrean Pesanan
                    </h3>

                    <form method="GET" action="{{ route('dashboard.penjual', [], false) }}" class="flex flex-wrap items-center gap-2">
                        <div class="relative">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama pemesan..." class="field text-xs !py-1.5 !pl-9 !pr-3 !w-48 !rounded-lg">
                        </div>
                        <select name="waktu_ambil" class="field text-xs !w-36 !py-1.5 !rounded-lg">
                            <option value="istirahat_1" @selected($selected_waktu_ambil === 'istirahat_1')>Istirahat 1</option>
                            <option value="istirahat_2" @selected($selected_waktu_ambil === 'istirahat_2')>Istirahat 2</option>
                        </select>
                        <button class="btn-secondary btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                        @if ($search !== '')
                            <a href="{{ route('dashboard.penjual', ['waktu_ambil' => $selected_waktu_ambil]) }}" class="text-xs font-medium" style="color: var(--brand);">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto -mx-5 sm:-mx-6">
                    <table class="table-clean min-w-full">
                        <thead>
                            <tr>
                                <th>Pembeli</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>WA</th>
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
                                        'siap_diambil' => 'badge-orange',
                                        'selesai' => 'badge-green',
                                        'dibatalkan' => 'badge-red',
                                        default => 'badge-gray',
                                    };
                                    $statusLabel = match($order->status_pesanan) {
                                        'menunggu' => 'Menunggu',
                                        'diproses' => 'Diproses',
                                        'siap_diambil' => 'Siap Diambil',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan',
                                        default => $order->status_pesanan,
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <span class="font-medium text-stone-700 block leading-tight">{{ $order->user->name }}</span>
                                                @if ($order->user->kelas || $order->user->jurusan)
                                                    <span class="text-[11px] leading-tight" style="color: var(--muted);">{{ $order->user->kelas }} {{ $order->user->jurusan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $order->menu->nama }}</td>
                                    <td><span class="font-semibold">{{ $order->jumlah }}</span></td>
                                    <td>
                                        @if ($order->user->no_whatsapp)
                                            @php
                                                $waNumber = preg_replace('/[^0-9]/', '', $order->user->no_whatsapp);
                                                if (str_starts_with($waNumber, '0')) $waNumber = '62' . substr($waNumber, 1);
                                                elseif (!str_starts_with($waNumber, '62')) $waNumber = '62' . $waNumber;
                                            @endphp
                                            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-lg transition-colors" style="background: #dcfce7; color: #16a34a;" title="Chat WhatsApp">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                Chat
                                            </a>
                                        @else
                                            <span class="text-[11px]" style="color: var(--muted);">—</span>
                                        @endif
                                    </td>
                                    <td><span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
                                    <td>
                                        @if (in_array($order->status_pesanan, ['selesai', 'dibatalkan']))
                                            <span class="text-xs" style="color: var(--muted);">&#8212;</span>
                                        @else
                                            <form method="POST" action="{{ route('dashboard.penjual.orders.status', $order, false) }}" class="flex gap-2 items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status_pesanan" class="field text-xs !w-32 !py-1.5 !rounded-lg" onchange="this.form.submit()">
                                                    <option value="" disabled selected>Ubah status</option>
                                                    @if ($order->status_pesanan === 'menunggu')
                                                        <option value="diproses">Diproses</option>
                                                        <option value="dibatalkan">Dibatalkan</option>
                                                    @elseif ($order->status_pesanan === 'diproses')
                                                        <option value="siap_diambil">Siap Diambil</option>
                                                        <option value="dibatalkan">Dibatalkan</option>
                                                    @elseif ($order->status_pesanan === 'siap_diambil')
                                                        <option value="selesai">Selesai</option>
                                                    @endif
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
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

    <style>
        @keyframes pulse-notif {
            0%, 100% { opacity: 1; }
            50% { opacity: .85; }
        }
    </style>
</x-app-layout>
