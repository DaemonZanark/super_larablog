<x-guest-layout>
    <div class="py-6">
        <div class="relative h-[60vh] flex items-center justify-center mb-16 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] to-transparent z-10"></div>
            <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Hellfest Atmosphere" class="absolute inset-0 w-full h-full object-cover opacity-50 grayscale hover:grayscale-0 transition duration-1000">
            <div class="relative z-20 text-center">
                <h1 class="text-6xl md:text-8xl font-black hf-title mb-4 italic tracking-tighter">GEEKPLACE</h1>
                <p class="text-xl md:text-2xl text-[#c5a059] font-bold uppercase tracking-[0.2em]">L'art de l'écriture, la force des mots</p>
                <div class="mt-8">
                    <a href="#latest" class="hf-btn-primary">Explorer les articles</a>
                </div>
            </div>
        </div>

        <div id="latest" class="mb-12 flex flex-col md:flex-row justify-between items-center border-b border-[#c5a059]/30 pb-4 gap-4">
            <h2 class="text-4xl font-black hf-title italic uppercase">Dernières Publications</h2>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('accueil') }}" class="text-[10px] font-black uppercase tracking-widest {{ !request('category') ? 'text-[#c5a059]' : 'text-gray-500 hover:text-white' }}">Tout</a>
                @foreach($categories as $category)
                    <a href="{{ route('accueil', ['category' => $category->id]) }}" class="text-[10px] font-black uppercase tracking-widest {{ request('category') == $category->id ? 'text-[#c5a059]' : 'text-gray-500 hover:text-white' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($articles as $article)
                <div class="hf-card flex flex-col group">
                    <div class="relative overflow-hidden aspect-video">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-[#111] flex items-center justify-center">
                                <span class="text-gray-700 hf-title italic text-xl">SANS IMAGE</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                            @foreach($article->categories as $category)
                                <span class="bg-[#c5a059] text-[#0a0a0a] text-[10px] font-black px-2 py-0.5 uppercase tracking-tighter">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-xs text-[#c5a059] font-bold uppercase mb-2 tracking-widest">
                            Publié par <a href="{{ route('blog.index', $article->user->id) }}" class="hover:text-white transition">{{ $article->user->name }}</a>
                        </div>

                        <h2 class="text-2xl font-bold mb-3 hf-title tracking-tight italic group-hover:text-white transition">
                            <a href="{{ route('blog.article', [$article->user, $article]) }}">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <p class="text-gray-400 text-sm mb-6 flex-1 line-clamp-3 leading-relaxed">
                            {{ $article->content }}
                        </p>

                        <div class="mt-6 pt-6 border-t border-[#c5a059]/10 flex justify-between items-center">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">{{ $article->created_at->translatedFormat('d M Y') }}</span>
                                <div class="flex gap-3 mt-1">
                                    <span class="text-[8px] text-[#c5a059] font-black uppercase tracking-widest">{{ $article->reading_time }} min de lecture</span>
                                    <span class="text-[8px] text-gray-600 font-black uppercase tracking-widest">{{ $article->views_count }} vues</span>
                                </div>
                            </div>
                            <a href="{{ route('blog.article', [$article->user, $article]) }}" class="text-[#c5a059] text-xs font-black uppercase tracking-widest group-hover:translate-x-2 transition">Lire la suite &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16 flex justify-center">
            {{ $articles->links() }}
        </div>
    </div>
</x-guest-layout>
