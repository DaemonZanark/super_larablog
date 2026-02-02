<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="hf-card p-10">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-black hf-title italic tracking-tighter">MOT DE PASSE OUBLIÉ ?</h2>
            </div>

            <div class="mb-6 text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-relaxed">
                Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe.
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="w-full py-4">
                        Envoyer le lien
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
