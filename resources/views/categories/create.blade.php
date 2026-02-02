<x-app-layout>
    <x-slot name="header">
        CRÉER UNE CATÉGORIE
    </x-slot>

    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <form method="post" action="{{ route('categories.store') }}" class="space-y-8">
            @csrf

            <div class="hf-card p-8 space-y-6">
                <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-sm border-b border-[#c5a059]/20 pb-4">Nouvelle Catégorie</h3>

                <div>
                    <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 font-bold uppercase tracking-widest text-sm" placeholder="ex: Rock, Metal, Critique...">
                    @error('name') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="hf-card p-8 flex items-center justify-between gap-6">
                <a href="{{ route('categories.index') }}" class="hf-btn-outline py-2 px-8">Annuler</a>
                <button type="submit" class="hf-btn-primary py-2 px-8">Créer</button>
            </div>
        </form>
    </div>
</x-app-layout>
