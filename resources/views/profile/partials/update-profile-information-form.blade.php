<section>
    <header>
        <h2 class="section-title">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Informasi Profil
        </h2>
        <p class="section-subtitle">Perbarui data diri dan informasi akun Anda.</p>
    </header>

    @if (!$user->profile_completed)
        <div class="mt-4 flex items-center gap-2 rounded-lg px-3 py-2 text-sm" style="background: #fef3c7; border: 1px solid #fbbf24; color: #92400e;">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Lengkapi profil Anda terlebih dahulu untuk mulai menggunakan aplikasi.
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div x-data="{ preview: null }">
            <label class="field-label">Foto Profil</label>
            <div class="flex items-center gap-4 mt-1">
                <div class="w-16 h-16 rounded-full overflow-hidden flex items-center justify-center text-white text-xl font-bold shrink-0" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover" />
                    </template>
                    <template x-if="!preview">
                        @if ($user->foto_profile)
                            <img src="{{ asset('storage/' . $user->foto_profile) }}" class="w-full h-full object-cover" />
                        @else
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </template>
                </div>
                <div class="flex-1">
                    <label class="btn-secondary btn-sm text-xs cursor-pointer inline-block">
                        Pilih Foto
                        <input type="file" name="foto_profile" accept="image/jpeg,image/png,image/webp" class="hidden"
                            @change="if ($event.target.files[0]) { preview = URL.createObjectURL($event.target.files[0]) }" />
                    </label>
                    <p class="text-xs mt-1" style="color: var(--muted);">JPG, PNG, atau WebP. Maks 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('foto_profile')" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div>
                <label for="nama_lengkap" class="field-label">Nama Lengkap</label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" class="field" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required />
                <x-input-error class="mt-1" :messages="$errors->get('nama_lengkap')" />
            </div>

            <div>
                <label for="email" class="field-label">Email</label>
                <input id="email" name="email" type="email" class="field" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            Email belum diverifikasi.
                            <button form="send-verification" class="underline text-sm hover:text-gray-900">Kirim ulang link verifikasi.</button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">Link verifikasi baru telah dikirim.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if ($user->role === 'penjual')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div>
                    <label for="nik" class="field-label">NIK</label>
                    <input id="nik" name="nik" type="text" class="field" value="{{ old('nik', $user->nik) }}" required maxlength="20" />
                    <x-input-error class="mt-1" :messages="$errors->get('nik')" />
                </div>
            </div>
        @else
            <div x-data="{ tipe: '{{ old('tipe_pengguna', $user->tipe_pengguna ?? '') }}' }" class="space-y-4">
                <div>
                    <label for="tipe_pengguna" class="field-label">Status</label>
                    <select id="tipe_pengguna" name="tipe_pengguna" x-model="tipe" class="field" required>
                        <option value="">— Pilih Status —</option>
                        <option value="siswa" :selected="tipe === 'siswa'">Siswa</option>
                        <option value="guru" :selected="tipe === 'guru'">Guru</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('tipe_pengguna')" />
                </div>

                {{-- NIS for siswa --}}
                <div x-show="tipe === 'siswa'" x-cloak>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="nis" class="field-label">NIS</label>
                            <input id="nis" name="nis" type="text" class="field" value="{{ old('nis', $user->nis) }}" maxlength="20" />
                            <x-input-error class="mt-1" :messages="$errors->get('nis')" />
                        </div>
                        <div>
                            <label for="kelas_siswa" class="field-label">Kelas</label>
                            <input id="kelas_siswa" name="kelas" type="text" class="field" value="{{ old('kelas', $user->kelas) }}" placeholder="cth: XII" maxlength="20" />
                            <x-input-error class="mt-1" :messages="$errors->get('kelas')" />
                        </div>
                        <div>
                            <label for="jurusan_siswa" class="field-label">Jurusan</label>
                            <input id="jurusan_siswa" name="jurusan" type="text" class="field" value="{{ old('jurusan', $user->jurusan) }}" placeholder="cth: RPL" maxlength="100" />
                            <x-input-error class="mt-1" :messages="$errors->get('jurusan')" />
                        </div>
                    </div>
                </div>

                {{-- NIP/NIK for guru --}}
                <div x-show="tipe === 'guru'" x-cloak>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="nik_guru" class="field-label">NIP / NIK</label>
                            <input id="nik_guru" name="nik" type="text" class="field" value="{{ old('nik', $user->nik) }}" maxlength="20" />
                            <x-input-error class="mt-1" :messages="$errors->get('nik')" />
                        </div>
                        <div>
                            <label for="kelas_guru" class="field-label">Kelas (Wali Kelas)</label>
                            <input id="kelas_guru" name="kelas" type="text" class="field" value="{{ old('kelas', $user->kelas) }}" placeholder="cth: XII" maxlength="20" />
                            <x-input-error class="mt-1" :messages="$errors->get('kelas')" />
                        </div>
                        <div>
                            <label for="jurusan_guru" class="field-label">Jurusan</label>
                            <input id="jurusan_guru" name="jurusan" type="text" class="field" value="{{ old('jurusan', $user->jurusan) }}" placeholder="cth: RPL" maxlength="100" />
                            <x-input-error class="mt-1" :messages="$errors->get('jurusan')" />
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div>
                <label class="field-label">Jenis Kelamin</label>
                <div class="flex items-center gap-4 mt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="laki-laki" class="accent-[var(--brand)]" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki' ? 'checked' : '' }} required />
                        <span class="text-sm text-stone-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="perempuan" class="accent-[var(--brand)]" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan' ? 'checked' : '' }} required />
                        <span class="text-sm text-stone-700">Perempuan</span>
                    </label>
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('jenis_kelamin')" />
            </div>

            <div>
                <label for="no_whatsapp" class="field-label">Nomor WhatsApp</label>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-stone-500 font-medium">+62</span>
                    <input id="no_whatsapp" name="no_whatsapp" type="tel" class="field flex-1" value="{{ old('no_whatsapp', $user->no_whatsapp) }}" placeholder="81234567890" maxlength="15" />
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('no_whatsapp')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">Simpan Profil</button>
        </div>
    </form>
</section>
