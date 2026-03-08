<x-app-layout>
    <div class="py-8">
        <div class="content-wrap">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Profil Saya</h1>
                <p class="section-subtitle">Kelola informasi akun dan keamanan</p>
            </div>

            <div class="max-w-2xl space-y-6">
                <div class="panel-section">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="panel-section">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="panel-section">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
