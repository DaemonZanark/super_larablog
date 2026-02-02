<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black hf-title italic mb-2 text-red-700">
            Supprimer le compte
        </h2>

        <p class="text-[10px] text-red-900 font-bold uppercase tracking-widest mb-6 border-b border-red-900/10 pb-4">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Supprimer le compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.supprimer') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black hf-title italic mb-2 text-red-700">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>

            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-6">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Mot de passe" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Supprimer le compte
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
