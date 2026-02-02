<x-guest-layout>
    <div class="max-w-7xl mx-auto">
        <div class="hf-card overflow-hidden mb-12">
            <div class="relative h-48 bg-[#111] border-b border-[#c5a059]/20">
                <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/dark-matter.png');"></div>
            </div>

            <div class="px-8 pb-8">
                <div class="relative flex flex-col md:flex-row items-end gap-6 -mt-16 mb-8">
                    <div class="relative group">
                        <div class="w-32 h-32 md:w-40 md:h-40 bg-[#0a0a0a] border-4 border-[#c5a059] flex items-center justify-center overflow-hidden shadow-2xl">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                            @else
                                <span class="text-6xl font-black text-[#c5a059]">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 pb-2">
                        <h1 class="text-4xl md:text-5xl font-black hf-title italic tracking-tighter leading-none mb-2">{{ $user->name }}</h1>
                        <div class="flex flex-wrap gap-4 text-[10px] font-black uppercase tracking-widest text-gray-500">
                            <span>{{ $user->articles_count }} Articles</span>
                            <span class="w-1 h-1 bg-[#c5a059]/50 rounded-full self-center"></span>
                            <span>{{ $user->followers_count }} Abonnés</span>
                        </div>
                    </div>

                    <div class="flex gap-3 pb-2">
                        @auth
                            @if(Auth::id() !== $user->id)
                                <form action="{{ route('auteurs.suivre', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="{{ Auth::user()->isSubscribedTo($user) ? 'hf-btn-outline' : 'hf-btn-primary' }} py-2 px-6 text-xs">
                                        {{ Auth::user()->isSubscribedTo($user) ? 'Se désabonner' : 'S\'abonner' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('profile.edit') }}" class="hf-btn-outline py-2 px-6 text-xs">Modifier mon profil</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="hf-btn-primary py-2 px-6 text-xs">S'abonner</a>
                        @endauth
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2 space-y-8">
                        <div>
                            <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-xs mb-4 border-b border-[#c5a059]/20 pb-2">À propos de l'auteur</h3>
                            <p class="text-gray-400 leading-relaxed italic">
                                {{ $user->bio ?? "Cet auteur n'a pas encore rédigé de biographie. Son talent s'exprime avant tout à travers ses publications." }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-xs mb-6 border-b border-[#c5a059]/20 pb-2">Dernières Publications</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @forelse($articles as $article)
                                    <div class="hf-card group flex flex-col">
                                        <div class="aspect-video overflow-hidden">
                                            @if($article->image)
                                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 grayscale group-hover:grayscale-0">
                                            @else
                                                <div class="w-full h-full bg-[#0a0a0a] flex items-center justify-center italic text-gray-700 hf-title">SANS IMAGE</div>
                                            @endif
                                        </div>
                                        <div class="p-4 flex-1">
                                            <div class="text-[8px] font-black text-[#c5a059] uppercase tracking-widest mb-1">{{ $article->created_at->format('d/m/Y') }}</div>
                                            <h4 class="font-black hf-title italic leading-tight mb-4 line-clamp-2">{{ $article->title }}</h4>
                                            <a href="{{ route('blog.article', [$user, $article]) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition">Lire l'article &rarr;</a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-600 italic uppercase tracking-widest text-xs col-span-2">Aucun article publié pour le moment.</p>
                                @endforelse
                            </div>
                            <div class="mt-8">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-xs mb-4 border-b border-[#c5a059]/20 pb-2">Réseaux & Liens</h3>
                            <div class="space-y-4">
                                @if($user->instagram_url)
                                    <a href="{{ $user->instagram_url }}" target="_blank" class="flex items-center gap-3 text-gray-400 hover:text-white transition group">
                                        <div class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center group-hover:border-[#c5a059]">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-widest">Instagram</span>
                                    </a>
                                @endif

                                @if($user->twitter_url)
                                    <a href="{{ $user->twitter_url }}" target="_blank" class="flex items-center gap-3 text-gray-400 hover:text-white transition group">
                                        <div class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center group-hover:border-[#c5a059]">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-widest">X / Twitter</span>
                                    </a>
                                @endif

                                @if($user->portfolio_url)
                                    <a href="{{ $user->portfolio_url }}" target="_blank" class="flex items-center gap-3 text-gray-400 hover:text-white transition group">
                                        <div class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center group-hover:border-[#c5a059]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-widest">Portfolio</span>
                                    </a>
                                @endif

                                @if(!$user->instagram_url && !$user->twitter_url && !$user->portfolio_url)
                                    <p class="text-gray-600 italic text-[10px] uppercase tracking-widest">Aucun lien social renseigné.</p>
                                @endif
                            </div>
                        </div>

                        <div class="hf-card p-6 bg-[#111]">
                            <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-[10px] mb-4">Statistiques Auteur</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase">Total Vues</span>
                                    <span class="text-white font-black hf-title italic text-xl">{{ $user->articles()->sum('views_count') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-[10px] font-bold uppercase">Total Likes</span>
                                    <span class="text-white font-black hf-title italic text-xl">{{ $user->articles()->withCount('likes')->get()->sum('likes_count') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
