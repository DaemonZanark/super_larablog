<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-7xl font-black hf-title italic mb-4 tracking-tighter">ARCHIVES GLOBALES</h1>
                <p class="text-xl text-[#c5a059] font-bold uppercase tracking-[0.3em]">Explorez les publications de la communauté</p>
                <div class="w-32 h-1 bg-[#c5a059] mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Filtres -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="hf-card p-6">
                        <h3 class="text-[#c5a059] font-bold uppercase tracking-widest text-sm mb-4 border-b border-[#c5a059]/20 pb-2">Rechercher</h3>
                        <form action="{{ route('articles.archives') }}" method="GET">
                            <div class="relative flex items-center">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Mot-clé..." class="w-full bg-[#111] border-[#c5a059]/30 text-white text-sm focus:border-[#c5a059] focus:ring-0 placeholder-gray-600 uppercase font-bold tracking-widest pr-10 py-3">
                                <button type="submit" class="absolute right-0 top-0 bottom-0 px-3 text-[#c5a059] hover:text-white transition flex items-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="hf-card p-6">
                        <h3 class="text-[#c5a059] font-bold uppercase tracking-widest text-sm mb-4 border-b border-[#c5a059]/20 pb-2">Catégories</h3>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('articles.archives') }}" class="text-xs uppercase font-bold tracking-widest {{ !request()->has('category') ? 'text-[#c5a059]' : 'text-gray-500 hover:text-white' }}">Tout voir</a>
                            @foreach($categories as $category)
                                <a href="{{ route('articles.archives', ['category' => $category->id]) }}"
                                   class="text-xs uppercase font-bold tracking-widest {{ request('category') == $category->id ? 'text-[#c5a059]' : 'text-gray-500 hover:text-white' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="hf-card p-6">
                        <h3 class="text-[#c5a059] font-bold uppercase tracking-widest text-sm mb-4 border-b border-[#c5a059]/20 pb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('articles.archives', ['tag' => $tag->id]) }}"
                                   class="text-[10px] uppercase font-bold tracking-tighter px-2 py-1 border {{ request('tag') == $tag->id ? 'bg-[#c5a059] text-[#0a0a0a] border-[#c5a059]' : 'text-gray-500 border-gray-800 hover:border-[#c5a059] hover:text-[#c5a059]' }}">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Liste Auteurs/Articles -->
                <div class="lg:col-span-3 space-y-16">
                    @forelse($users as $user)
                        <section class="hf-card overflow-hidden">
                            <div class="p-8 border-b border-[#c5a059]/20 bg-[#111] flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-[#c5a059] flex items-center justify-center font-black text-[#0a0a0a] text-xl mr-4">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h2 class="text-3xl font-black hf-title italic tracking-tight">{{ $user->name }}</h2>
                                        <p class="text-[10px] font-bold uppercase text-gray-500 tracking-widest">
                                            @if(request()->anyFilled(['search', 'category', 'tag']))
                                                {{ $user->articles->count() }} {{ Str::plural('ARTICLE CORRESPONDANT', $user->articles->count()) }}
                                            @else
                                                {{ $user->articles->count() }} {{ Str::plural('ARTICLE', $user->articles->count()) }} AU TOTAL
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('blog.index', $user) }}" class="hf-btn-outline text-[10px] py-2 px-6">Voir son blog</a>
                            </div>

                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    @foreach($user->articles->take(3) as $article)
                                        <div class="group">
                                            <div class="relative aspect-video overflow-hidden mb-4 border border-[#c5a059]/10">
                                                @if($article->image)
                                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 grayscale group-hover:grayscale-0">
                                                @else
                                                    <div class="w-full h-full bg-[#0a0a0a] flex items-center justify-center italic text-gray-700 hf-title">NO IMAGE</div>
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] to-transparent opacity-60"></div>
                                                <div class="absolute bottom-4 left-4 right-4">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <p class="text-[8px] font-black text-[#c5a059] uppercase tracking-widest">{{ $article->created_at->format('d/m/Y') }}</p>
                                                        <p class="text-[8px] text-gray-400 font-black uppercase tracking-widest">{{ $article->reading_time }} MIN</p>
                                                    </div>
                                                    <h3 class="text-lg font-black text-white hf-title italic leading-tight group-hover:text-[#c5a059] transition line-clamp-2">{{ $article->title }}</h3>
                                                    <p class="text-[8px] text-gray-500 font-bold uppercase mt-2">{{ $article->views_count }} VUES</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('blog.article', [$user, $article]) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition">Lire l'article &rarr;</a>
                                        </div>
                                    @endforeach
                                </div>
                                @if($user->articles->count() > 3)
                                    <div class="mt-8 pt-6 border-t border-[#c5a059]/5 text-center">
                                        <a href="{{ route('blog.index', $user) }}" class="text-xs font-black uppercase tracking-widest text-[#c5a059] hover:text-white transition">Découvrir les {{ $user->articles->count() - 3 }} autres articles &rarr;</a>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @empty
                        <div class="hf-card p-12 text-center">
                            <p class="text-gray-500 italic uppercase tracking-widest">Aucun auteur ou article trouvé pour ces critères.</p>
                            @if(request()->anyFilled(['search', 'category', 'tag']))
                                <a href="{{ route('articles.archives') }}" class="text-[#c5a059] hover:underline mt-4 inline-block font-bold uppercase text-xs">Réinitialiser les filtres</a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-16 flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
