<section>
    <header>
        <h2 class="text-2xl font-black hf-title italic mb-2">
            Informations du Profil
        </h2>

        <p class="text-[10px] text-[#c5a059] font-bold uppercase tracking-widest mb-6 border-b border-[#c5a059]/10 pb-4">
            Mettez à jour les informations de votre profil et votre adresse email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <x-input-label for="name" value="Nom" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-xs mt-2 text-white">
                                Votre adresse email n'est pas vérifiée.

                                <button form="send-verification" class="underline text-xs text-[#c5a059] hover:text-white transition focus:outline-none">
                                    Cliquez ici pour renvoyer l'email de vérification.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-bold text-xs text-green-500 uppercase tracking-widest">
                                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <x-input-label for="avatar" value="Photo de Profil (Avatar)" />
                    @if($user->avatar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-20 h-20 object-cover border border-[#c5a059]/30">
                        </div>
                    @endif
                    <input type="file" name="avatar" id="avatar" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-[#c5a059] file:text-[#0a0a0a] hover:file:bg-[#e0bc7a] cursor-pointer">
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="bio" value="Biographie" />
                    <textarea id="bio" name="bio" class="bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 font-bold tracking-widest text-sm p-4 w-full h-32" placeholder="Dites-en plus sur vous...">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                </div>

                <div>
                    <x-input-label for="instagram_url" value="Lien Instagram" />
                    <x-text-input id="instagram_url" name="instagram_url" type="text" class="mt-1 block w-full" :value="old('instagram_url', $user->instagram_url)" placeholder="https://instagram.com/..." />
                    <x-input-error class="mt-2" :messages="$errors->get('instagram_url')" />
                </div>

                <div>
                    <x-input-label for="twitter_url" value="Lien X (Twitter)" />
                    <x-text-input id="twitter_url" name="twitter_url" type="text" class="mt-1 block w-full" :value="old('twitter_url', $user->twitter_url)" placeholder="https://x.com/..." />
                    <x-input-error class="mt-2" :messages="$errors->get('twitter_url')" />
                </div>

                <div>
                    <x-input-label for="portfolio_url" value="Lien Portfolio / Site" />
                    <x-text-input id="portfolio_url" name="portfolio_url" type="text" class="mt-1 block w-full" :value="old('portfolio_url', $user->portfolio_url)" placeholder="https://mon-site.fr" />
                    <x-input-error class="mt-2" :messages="$errors->get('portfolio_url')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-[#c5a059]/10">
            <x-primary-button>Enregistrer les modifications</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold uppercase tracking-widest text-[#c5a059]"
                >Enregistré.</p>
            @endif
        </div>
    </form>
</section>
