<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Statistik Penjualan</h1>
                    <p class="section-subtitle">Ringkasan data penjualan hari ini</p>
                </div>
                <span class="badge-orange text-xs">{{ $today }}</span>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="metric-card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="metric-label">Total Pesanan</p>
                            <p class="metric-value">{{ $stats['total_pesanan_hari_ini'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--brand-soft);">
                            <svg class="w-5 h-5" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
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
                            <p class="metric-label">Omzet Hari Ini</p>
                            <p class="metric-value text-lg">Rp {{ number_format($stats['omzet_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--accent-soft);">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Breakdown -->
            <div class="panel-section">
                <h3 class="section-title mb-4">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Status Pesanan Hari Ini
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl text-center" style="background-color: var(--warn-bg);">
                        <p class="text-2xl font-bold text-amber-700">{{ $stats['menunggu'] }}</p>
                        <p class="text-xs font-medium text-amber-600 mt-1">Menunggu</p>
                    </div>
                    <div class="p-4 rounded-xl text-center" style="background-color: var(--info-bg);">
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['diproses'] }}</p>
                        <p class="text-xs font-medium text-blue-600 mt-1">Diproses</p>
                    </div>
                    <div class="p-4 rounded-xl text-center" style="background-color: var(--brand-soft);">
                        <p class="text-2xl font-bold" style="color: var(--brand);">{{ $stats['siap_diambil'] }}</p>
                        <p class="text-xs font-medium" style="color: var(--brand);">Siap Diambil</p>
                    </div>
                    <div class="p-4 rounded-xl text-center" style="background-color: var(--ok-bg);">
                        <p class="text-2xl font-bold text-emerald-700">{{ $stats['selesai'] }}</p>
                        <p class="text-xs font-medium text-emerald-600 mt-1">Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
