<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400 font-bold uppercase tracking-widest">
        Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons un autre avec plaisir.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-bold text-sm text-[#c5a059] uppercase tracking-widest">
            Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de votre inscription.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Renvoyer l'email
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-400 hover:text-white font-bold uppercase tracking-widest">
                Déconnexion
            </button>
        </form>
    </div>
</x-guest-layout>
