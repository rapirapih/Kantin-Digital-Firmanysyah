<x-app-layout>
    <div class="py-8">
        <div class="content-wrap">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Profil Saya</h1>
                <p class="section-subtitle">Kelola informasi akun dan keamanan</p>
            </div>

            <div class="space-y-6">
                <div class="panel-section">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="panel-section" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="w-full flex items-center justify-between">
                            <h2 class="section-title">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Ubah Password
                            </h2>
                            <svg class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-4">
                            @include('profile.partials.update-password-form', ['hideHeader' => true])
                        </div>
                    </div>

                    <div class="panel-section">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
