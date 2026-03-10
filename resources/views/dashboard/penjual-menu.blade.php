<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Kelola Menu</h1>
                    <p class="section-subtitle">Tambah, edit, dan hapus menu Anda</p>
                </div>
                <span class="badge-gray text-xs">{{ $menus->count() }} menu</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Add Menu Form -->
                <div class="lg:col-span-2 panel-section" x-data="{ preview: null }">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Menu Baru
                    </h3>
                    <form method="POST" action="{{ route('dashboard.penjual.menus.store', [], false) }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="field-label">Nama Menu</label>
                            <input name="nama" placeholder="Contoh: Nasi Goreng Spesial" class="field" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="field-label">Kategori</label>
                                <select name="kategori" class="field" required>
                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Stok</label>
                                <input name="stok" type="number" min="0" placeholder="50" class="field" required>
                            </div>
                        </div>
                        <div>
                            <label class="field-label">Harga (Rp)</label>
                            <input name="harga" type="number" min="0" placeholder="10000" class="field" required>
                        </div>
                        <div>
                            <label class="field-label">Foto (opsional)</label>
                            <div class="mt-1">
                                <template x-if="preview">
                                    <div class="relative mb-2">
                                        <img :src="preview" class="w-full h-36 object-cover rounded-xl border" style="border-color: var(--line);" />
                                        <button type="button" @click="preview = null; $refs.fotoInput.value = ''" class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center text-xs hover:bg-black/70">&times;</button>
                                    </div>
                                </template>
                                <label class="btn-secondary btn-sm text-xs cursor-pointer inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Pilih Foto
                                    <input x-ref="fotoInput" name="foto" type="file" accept="image/*" class="hidden" @change="if ($event.target.files[0]) { preview = URL.createObjectURL($event.target.files[0]) }">
                                </label>
                                <span class="text-xs ml-2" style="color: var(--muted);">JPG, PNG, WebP</span>
                            </div>
                        </div>
                        <button class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Simpan Menu
                        </button>
                    </form>
                </div>

                <!-- Menu List -->
                <div class="lg:col-span-3 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Daftar Menu Saya
                        </h3>
                    </div>

                    @forelse ($menus as $menu)
                        <div class="panel-section" x-data="{ editing: false, editPreview: null }">
                            <div class="flex gap-4">
                                <!-- Thumbnail -->
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 flex items-center justify-center" style="background-color: var(--surface);">
                                    @if ($menu->foto)
                                        <img src="{{ asset('storage/' . $menu->foto) }}" class="w-full h-full object-cover" alt="{{ $menu->nama }}" />
                                    @else
                                        <svg class="w-8 h-8" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h4 class="font-semibold text-stone-800 leading-tight">{{ $menu->nama }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-sm font-bold" style="color: var(--brand);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                                <span class="badge {{ $menu->stok > 0 ? 'badge-green' : 'badge-red' }} text-[10px]">Stok: {{ $menu->stok }}</span>
                                                <span class="badge badge-gray text-[10px]">{{ $menu->kategori }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <button @click="editing = !editing" class="btn-secondary btn-sm !px-2" :class="editing && '!bg-stone-200'">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <form method="POST" action="{{ route('dashboard.penjual.menus.delete', $menu, false) }}" x-data x-on:submit.prevent="$dispatch('confirm-action', { title: 'Hapus Menu', message: 'Yakin ingin menghapus menu {{ addslashes($menu->nama) }}?', type: 'danger', confirmText: 'Ya, Hapus', form: $el })">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-danger btn-sm !px-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Form (collapsible) -->
                            <div x-show="editing" x-collapse x-cloak class="mt-4 pt-4" style="border-top: 1px solid var(--line-light);">
                                <form method="POST" action="{{ route('dashboard.penjual.menus.update', $menu, false) }}" class="space-y-3" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="field-label text-xs">Nama</label>
                                            <input name="nama" value="{{ $menu->nama }}" class="field text-sm" required>
                                        </div>
                                        <div>
                                            <label class="field-label text-xs">Kategori</label>
                                            <select name="kategori" class="field text-sm" required>
                                                @foreach ($kategoris as $kat)
                                                    <option value="{{ $kat }}" {{ $menu->kategori === $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="field-label text-xs">Harga</label>
                                            <input name="harga" type="number" min="0" value="{{ (float) $menu->harga }}" class="field text-sm" required>
                                        </div>
                                        <div>
                                            <label class="field-label text-xs">Stok</label>
                                            <input name="stok" type="number" min="0" value="{{ $menu->stok }}" class="field text-sm" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label text-xs">Ganti Foto</label>
                                        <div class="mt-1 flex items-center gap-3">
                                            <template x-if="editPreview">
                                                <img :src="editPreview" class="w-14 h-14 rounded-lg object-cover border" style="border-color: var(--line);" />
                                            </template>
                                            <label class="btn-secondary btn-sm text-xs cursor-pointer inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                Pilih
                                                <input name="foto" type="file" accept="image/*" class="hidden" @change="if ($event.target.files[0]) { editPreview = URL.createObjectURL($event.target.files[0]) }">
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn-primary btn-sm w-full">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="panel-section">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <p>Belum ada menu. Tambah menu pertamamu!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
