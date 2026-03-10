<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Kelola Kategori</h1>
                    <p class="section-subtitle">Tambah, ubah, atau hapus kategori menu</p>
                </div>
                <a href="{{ route('dashboard.admin') }}" class="btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Form -->
                <div class="panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Kategori
                    </h3>
                    <form method="POST" action="{{ route('dashboard.admin.kategori.store', [], false) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="field-label">Nama Kategori</label>
                            <input name="nama" class="field" placeholder="Contoh: dessert" required maxlength="100">
                        </div>
                        <button class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah
                        </button>
                    </form>
                </div>

                <!-- List -->
                <div class="lg:col-span-2 panel-section overflow-hidden">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Daftar Kategori
                        </h3>
                        <span class="badge-gray text-xs">{{ $kategoris->count() }} kategori</span>
                    </div>

                    <div class="space-y-3">
                        @forelse ($kategoris as $kategori)
                            <div class="flex items-center justify-between p-3 rounded-xl border" style="border-color: var(--line);" x-data="{ editing: false }">
                                <!-- Display mode -->
                                <div x-show="!editing" class="flex items-center gap-3 flex-1">
                                    <span class="badge-orange text-sm font-medium">{{ ucfirst($kategori->nama) }}</span>
                                    <span class="text-xs" style="color: var(--muted);">{{ $kategori->menus_count }} menu</span>
                                </div>
                                <div x-show="!editing" class="flex items-center gap-2">
                                    <button @click="editing = true" class="btn-secondary btn-sm">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('dashboard.admin.kategori.delete', $kategori, false) }}" x-data x-on:submit.prevent="$dispatch('confirm-action', { title: 'Hapus Kategori', message: 'Yakin ingin menghapus kategori {{ $kategori->nama }}?', type: 'danger', confirmText: 'Ya, Hapus', form: $el })">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger btn-sm">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>

                                <!-- Edit mode -->
                                <form x-show="editing" x-cloak method="POST" action="{{ route('dashboard.admin.kategori.update', $kategori, false) }}" class="flex items-center gap-2 flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input name="nama" value="{{ $kategori->nama }}" class="field text-sm flex-1" required maxlength="100">
                                    <button class="btn-primary btn-sm">Simpan</button>
                                    <button type="button" @click="editing = false" class="btn-secondary btn-sm">Batal</button>
                                </form>
                            </div>
                        @empty
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                <p>Belum ada kategori.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
