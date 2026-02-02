<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="hf-card p-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black hf-title italic tracking-tighter">INSCRIPTION</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Rejoindre la Communauté</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nom" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                    <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full py-4 text-sm">
                        S'INSCRIRE
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Déjà membre ? <a href="{{ route('login') }}" class="text-[#c5a059] hover:underline">Se connecter</a></p>
        </div>
    </div>
</x-guest-layout>
