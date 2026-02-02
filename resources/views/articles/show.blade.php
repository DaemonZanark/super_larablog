<x-app-layout>
    <x-slot name="header">
        GESTION DES PUBLICATIONS
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-[#c5a059] text-[#0a0a0a] p-4 font-black uppercase tracking-widest text-xs mb-8">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-800 text-white p-4 font-black uppercase tracking-widest text-xs mb-8">
                    {{ session('error') }}
                </div>
            @endif

            <div class="hf-card overflow-hidden">
                <div class="p-8 border-b border-[#c5a059]/20 flex justify-between items-center bg-[#111]">
                    <h3 class="text-xl font-black hf-title italic">VOS ARTICLES</h3>
                    <a href="{{ route('articles.create') }}" class="hf-btn-primary text-[10px]">Écrire un article</a>
                </div>

                <div class="p-0">
                    @if ($articles->isEmpty())
                        <div class="p-20 text-center">
                            <p class="text-gray-500 italic uppercase tracking-widest mb-6">Le silence est assourdissant. Commencez à écrire.</p>
                            <a href="{{ route('articles.create') }}" class="hf-btn-outline text-[10px]">Créer un article</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 divide-y divide-[#c5a059]/10">
                            @foreach ($articles as $article)
                                <div class="p-8 hover:bg-white/5 transition group">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                @foreach($article->categories as $category)
                                                    <span class="text-[9px] font-black uppercase tracking-tighter border border-[#c5a059]/50 px-2 text-[#c5a059]">{{ $category->name }}</span>
                                                @endforeach
                                                @if($article->draft)
                                                    <span class="text-[9px] font-black uppercase tracking-tighter border border-yellow-800 px-2 text-yellow-600">Brouillon</span>
                                                @endif
                                            </div>
                                            <h2 class="text-2xl font-black hf-title italic group-hover:text-white transition">{{ $article->title }}</h2>
                                            <div class="flex gap-4 mt-2 text-[10px] font-bold uppercase text-gray-600">
                                                <span>{{ $article->comments->count() }} Commentaires</span>
                                                <span>{{ $article->likes->count() }} J'aime</span>
                                                <span>{{ $article->created_at->format('d/m/Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="flex gap-3">
                                            <a href="{{ route('articles.edit', $article) }}" class="hf-btn-outline text-[10px] py-1 px-4 border-[#c5a059]/30">Modifier</a>
                                            <a href="{{ route('blog.article', [Auth::user(), $article]) }}" target="_blank" class="hf-btn-outline text-[10px] py-1 px-4 border-white text-white hover:bg-white">Voir</a>
                                            <form action="{{ route('articles.delete', $article) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="hf-btn-outline text-[10px] py-1 px-4 border-red-900 text-red-700 hover:bg-red-900 hover:text-white">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-8 border-t border-[#c5a059]/10">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
