<x-guest-layout>
    <div class="mb-12 text-center">
        <h2 class="text-5xl font-black hf-title italic mb-2 tracking-tighter">
            ARCHIVES DE {{ $user->name }}
        </h2>
        <div class="w-24 h-1 bg-[#c5a059] mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Filtres -->
        <div class="lg:col-span-1 space-y-8">
            <div class="hf-card p-6">
                <h3 class="text-[#c5a059] font-bold uppercase tracking-widest text-sm mb-4 border-b border-[#c5a059]/20 pb-2">Rechercher</h3>
                <form action="{{ route('blog.index', $user->id) }}" method="GET">
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
                    <a href="{{ route('blog.index', $user->id) }}" class="text-xs uppercase font-bold tracking-widest {{ !request()->has('category') ? 'text-[#c5a059]' : 'text-gray-500 hover:text-white' }}">Tout voir</a>
                    @foreach($categories as $category)
                        <a href="{{ route('blog.index', [$user->id, 'category' => $category->id]) }}"
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
                        <a href="{{ route('blog.index', [$user->id, 'tag' => $tag->id]) }}"
                           class="text-[10px] uppercase font-bold tracking-tighter px-2 py-1 border {{ request('tag') == $tag->id ? 'bg-[#c5a059] text-[#0a0a0a] border-[#c5a059]' : 'text-gray-500 border-gray-800 hover:border-[#c5a059] hover:text-[#c5a059]' }}">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Liste Articles -->
        <div class="lg:col-span-3 space-y-10">
            @if ($articles->isEmpty())
                <div class="hf-card p-12 text-center">
                    <p class="text-gray-500 italic uppercase tracking-widest">Aucun article trouvé dans cette section.</p>
                    @if(request()->anyFilled(['search', 'category', 'tag']))
                        <a href="{{ route('blog.index', $user->id) }}" class="text-[#c5a059] hover:underline mt-4 inline-block font-bold uppercase text-xs">Réinitialiser les filtres</a>
                    @endif
                </div>
            @else
                @foreach ($articles as $article)
                <div class="hf-card flex flex-col md:flex-row overflow-hidden group">
                    @if($article->image)
                        <div class="md:w-1/3 overflow-hidden">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 min-h-[200px]">
                        </div>
                    @endif
                    <div class="flex-1 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#c5a059]">
                                <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
                                <span class="w-8 h-[1px] bg-[#c5a059]/30"></span>
                                <span>{{ $article->reading_time }} min de lecture</span>
                                <span class="w-8 h-[1px] bg-[#c5a059]/30"></span>
                                <span>{{ $article->categories->first()->name ?? 'Général' }}</span>
                            </div>
                            <h2 class="text-3xl font-black hf-title italic mb-4 group-hover:text-white transition">{{ $article->title }}</h2>
                            <p class="text-gray-400 text-sm leading-relaxed line-clamp-2">{{ Str::limit($article->content, 200) }}</p>
                        </div>

                        <div class="mt-6 pt-6 border-t border-[#c5a059]/10 flex justify-between items-center">
                            <a href="{{ route('blog.article', [$user, $article]) }}" class="hf-btn-outline text-[10px] py-2 px-4">Lire l'article</a>
                            <div class="flex gap-4 text-gray-600">
                                <span class="flex items-center gap-1 text-[10px] font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg> {{ $article->views_count }}</span>
                                <span class="flex items-center gap-1 text-[10px] font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 10.133a1.988 1.988 0 00-.8.2z"></path></svg> {{ $article->likes->count() }}</span>
                                <span class="flex items-center gap-1 text-[10px] font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zm-4 0H9v2h2V9z" clip-rule="evenodd"></path></svg> {{ $article->comments->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
