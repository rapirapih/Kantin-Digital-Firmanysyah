<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Tarik Tunai</h1>
                    <p class="section-subtitle">Tukarkan saldo menjadi uang tunai</p>
                </div>
            </div>



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

                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; margin-bottom: 12px;">
                                <div style="font-size: 11px; font-weight: 600; color: #16a34a; margin-bottom: 2px;">Jumlah Penukaran</div>
                                <div style="font-size: 22px; font-weight: 800; color: #15803d;">Rp {{ number_format(session('withdrawal_jumlah'), 0, ',', '.') }}</div>
                            </div>

                            <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 16px; margin-bottom: 12px;">
                                <div style="font-size: 11px; font-weight: 600; color: #92400e; margin-bottom: 2px;">Potongan Sekolah (10%)</div>
                                <div style="font-size: 18px; font-weight: 700; color: #b45309;">- Rp {{ number_format(session('withdrawal_potongan'), 0, ',', '.') }}</div>
                            </div>

                            <div style="background: #ecfdf5; border: 2px solid #6ee7b7; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
                                <div style="font-size: 11px; font-weight: 600; color: #059669; margin-bottom: 2px;">Uang Tunai Diterima</div>
                                <div style="font-size: 24px; font-weight: 800; color: #047857;">Rp {{ number_format(session('withdrawal_diterima'), 0, ',', '.') }}</div>
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

            <!-- Tukar Saldo & Riwayat Penukaran -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Tukar Saldo Form -->
                <div class="lg:col-span-2 panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Tukar Saldo ke Uang Tunai
                    </h3>
                    <p class="text-sm mb-4" style="color: var(--muted);">Tukarkan saldo Anda menjadi uang tunai. Dikenakan <strong style="color: var(--brand);">potongan 10%</strong> untuk sekolah. Anda akan mendapat kode penukaran yang bisa ditunjukkan ke admin.</p>
                    <form method="POST" action="{{ route('dashboard.penjual.withdrawal.store', [], false) }}" class="space-y-4"
                          x-data="{ showModal: false, confirmed: false, jumlah: '' }"
                          @submit.prevent="if (confirmed) { confirmed = false; $el.submit(); } else { showModal = true; }">
                        @csrf
                        <div>
                            <label class="field-label">Saldo Tersedia</label>
                            <p class="text-lg font-bold" style="color: var(--accent);">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="field-label">Jumlah Penukaran (Rp)</label>
                            <input name="jumlah" type="number" min="1000" max="{{ $saldo }}" placeholder="Contoh: 50000" class="field" required x-model="jumlah">
                            <template x-if="jumlah >= 1000">
                                <p class="text-xs mt-1" style="color: var(--muted);">Potongan 10%: Rp <span x-text="Math.round(jumlah * 0.1).toLocaleString('id-ID')"></span> &mdash; Diterima: Rp <span x-text="Math.round(jumlah * 0.9).toLocaleString('id-ID')" class="font-semibold" style="color: var(--accent);"></span></p>
                            </template>
                        </div>
                        <button type="submit" class="btn-primary w-full" {{ $saldo < 1000 ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Tukar Saldo
                        </button>

                        <!-- Custom Confirmation Modal -->
                        <template x-teleport="body">
                            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" style="display: none; padding: 16px;">
                                <div class="absolute inset-0" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);" @click="showModal = false"></div>

                                <div x-show="showModal"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-90"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-90"
                                     class="relative"
                                     style="background: #ffffff; border-radius: 16px; width: 340px; max-width: calc(100vw - 32px); box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(0,0,0,0.06);">

                                    <div style="height: 4px; background: linear-gradient(90deg, #b91c1c, #dc2626, #ef4444); border-radius: 16px 16px 0 0;"></div>

                                    <div style="padding: 24px 24px 20px;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #fef2f2; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                            <svg style="width: 22px; height: 22px; color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>

                                        <h3 style="font-size: 16px; font-weight: 700; color: #1c1917; text-align: center; margin: 0 0 4px;">Tukar Saldo?</h3>
                                        <p style="font-size: 13px; color: #78716c; text-align: center; margin: 0 0 16px;">Saldo akan dipotong dan tidak bisa dikembalikan</p>

                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 16px; text-align: center; margin-bottom: 8px;">
                                            <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #16a34a; margin-bottom: 2px;">Jumlah</div>
                                            <div style="font-size: 26px; font-weight: 800; color: #15803d;">Rp <span x-text="Number(jumlah || 0).toLocaleString('id-ID')"></span></div>
                                        </div>

                                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 10px 16px; text-align: center; margin-bottom: 8px;">
                                            <div style="font-size: 11px; font-weight: 600; color: #92400e; margin-bottom: 2px;">Potongan Sekolah (10%)</div>
                                            <div style="font-size: 18px; font-weight: 700; color: #b45309;">- Rp <span x-text="Math.round(Number(jumlah || 0) * 0.1).toLocaleString('id-ID')"></span></div>
                                        </div>

                                        <div style="background: #ecfdf5; border: 2px solid #6ee7b7; border-radius: 12px; padding: 10px 16px; text-align: center; margin-bottom: 12px;">
                                            <div style="font-size: 11px; font-weight: 600; color: #059669; margin-bottom: 2px;">Uang Tunai Diterima</div>
                                            <div style="font-size: 22px; font-weight: 800; color: #047857;">Rp <span x-text="Math.round(Number(jumlah || 0) * 0.9).toLocaleString('id-ID')"></span></div>
                                        </div>

                                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 8px 10px; display: flex; align-items: flex-start; gap: 6px;">
                                            <svg style="width: 14px; height: 14px; color: #d97706; flex-shrink: 0; margin-top: 1px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span style="font-size: 11px; line-height: 1.4; color: #92400e;">Tunjukkan kode penukaran ke admin untuk terima uang tunai.</span>
                                        </div>
                                    </div>

                                    <div style="height: 1px; background: #e7e5e4;"></div>

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
                                    <th>Potongan</th>
                                    <th>Diterima</th>
                                    <th>Kode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdrawals as $wd)
                                    <tr>
                                        <td class="text-xs" style="color: var(--muted);">{{ $wd->created_at->format('d M Y, H:i') }}</td>
                                        <td class="font-semibold">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</td>
                                        <td class="text-xs" style="color: var(--brand);">- Rp {{ number_format($wd->potongan, 0, ',', '.') }}</td>
                                        <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format((float) $wd->jumlah - (float) $wd->potongan, 0, ',', '.') }}</td>
                                        <td><span class="font-mono text-xs tracking-widest font-bold">{{ $wd->kode_penukaran }}</span></td>
                                        <td>
                                            <span class="badge {{ $wd->status === 'berhasil' ? 'badge-green' : 'badge-yellow' }}">{{ $wd->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
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
        </div>
    </div>
</x-app-layout>
