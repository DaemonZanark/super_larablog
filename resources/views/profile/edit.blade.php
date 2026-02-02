<x-app-layout>
    <x-slot name="header">
        PARAMÈTRES DU PROFIL
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="hf-card p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="hf-card p-8 border-yellow-900/30">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="hf-card p-8 border-red-900/30">
                <div class="max-w-xl text-red-700">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
