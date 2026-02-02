<x-app-layout>
    <x-slot name="header">
        GESTION DES TAGS
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-[#c5a059] text-[#0a0a0a] p-4 font-black uppercase tracking-widest text-xs mb-8">
                    {{ session('success') }}
                </div>
            @endif

            <div class="hf-card overflow-hidden">
                <div class="p-8 border-b border-[#c5a059]/20 flex justify-between items-center bg-[#111]">
                    <h3 class="text-xl font-black hf-title italic">TOUS LES TAGS</h3>
                    <a href="{{ route('tags.create') }}" class="hf-btn-primary text-[10px]">Ajouter un tag</a>
                </div>

                <div class="p-0">
                    @if ($tags->isEmpty())
                        <div class="p-20 text-center">
                            <p class="text-gray-500 italic uppercase tracking-widest mb-6">Aucun tag pour le moment.</p>
                            <a href="{{ route('tags.create') }}" class="hf-btn-outline text-[10px]">Créer le premier</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 divide-y divide-[#c5a059]/10">
                            @foreach ($tags as $tag)
                                <div class="p-6 hover:bg-white/5 transition group">
                                    <div class="flex justify-between items-center gap-6">
                                        <div class="flex-1">
                                            <h2 class="text-xl font-black hf-title italic group-hover:text-white transition">#{{ $tag->name }}</h2>
                                            <p class="text-[10px] font-bold uppercase text-gray-600 mt-1">
                                                {{ $tag->articles_count }} {{ Str::plural('Article', $tag->articles_count) }} associé(s)
                                            </p>
                                        </div>

                                        <div class="flex gap-3">
                                            <a href="{{ route('tags.edit', $tag) }}" class="hf-btn-outline text-[10px] py-1 px-4 border-[#c5a059]/30">Modifier</a>
                                            <form action="{{ route('tags.delete', $tag) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="hf-btn-outline text-[10px] py-1 px-4 border-red-900 text-red-700 hover:bg-red-900 hover:text-white">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
