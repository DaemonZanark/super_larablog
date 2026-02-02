<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="hf-card p-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black hf-title italic tracking-tighter">CONNEXION</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-2">Espace Membre</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 bg-[#111] border-[#c5a059]/30 text-[#c5a059] focus:ring-0 rounded-none cursor-pointer" name="remember">
                    <label for="remember_me" class="ms-2 text-[10px] font-bold uppercase tracking-widest text-gray-500 cursor-pointer">Se souvenir de moi</label>
                </div>

                <div class="pt-4 space-y-4">
                    <x-primary-button class="w-full py-4 text-sm">
                        SE CONNECTER
                    </x-primary-button>

                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold uppercase tracking-widest text-[#c5a059] hover:text-white transition" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Pas encore de compte ? <a href="{{ route('register') }}" class="text-[#c5a059] hover:underline">S'inscrire</a></p>
        </div>
    </div>
</x-guest-layout>
