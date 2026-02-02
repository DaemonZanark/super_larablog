<x-guest-layout>
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('blog.index', $article->user) }}" class="inline-flex items-center text-[#c5a059] font-bold uppercase tracking-widest text-xs mb-8 hover:translate-x-[-8px] transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour aux articles
        </a>

        <article class="hf-card overflow-hidden">
            @if($article->image)
                <div class="w-full h-[400px] relative">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] to-transparent"></div>
                </div>
            @endif

            <div class="p-8 md:p-12">
                <div class="flex flex-wrap gap-4 mb-6">
                    @foreach($article->categories as $category)
                        <span class="bg-[#c5a059] text-[#0a0a0a] text-xs font-black px-3 py-1 uppercase tracking-tighter">{{ $category->name }}</span>
                    @endforeach
                </div>

                <h1 class="text-4xl md:text-6xl font-black hf-title italic mb-6 leading-none tracking-tighter">{{ $article->title }}</h1>

                <div class="flex items-center gap-6 mb-12 pb-6 border-b border-[#c5a059]/20">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-[#c5a059] flex items-center justify-center font-bold text-[#0a0a0a] rounded-none mr-3">
                            @if($article->user->avatar)
                                <img src="{{ asset('storage/' . $article->user->avatar) }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($article->user->name, 0, 1) }}
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest leading-none">Auteur</p>
                            <a href="{{ route('auteurs.profil', $article->user) }}" class="text-[#c5a059] font-bold hover:text-white transition uppercase text-xs">{{ $article->user->name }}</a>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest leading-none">Date</p>
                        <p class="text-white font-bold uppercase text-xs">{{ $article->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest leading-none">Lecture</p>
                        <p class="text-white font-bold uppercase text-xs">{{ $article->reading_time }} min</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest leading-none">Vues</p>
                        <p class="text-white font-bold uppercase text-xs">{{ $article->views_count }}</p>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none mb-16">
                    <p class="text-gray-300 text-xl leading-relaxed first-letter:text-5xl first-letter:font-black first-letter:text-[#c5a059] first-letter:mr-3 first-letter:float-left">
                        {{ $article->content }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-6 py-8 border-t border-b border-[#c5a059]/20 mb-16">
                    <div class="flex items-center gap-8">
                        <div class="flex items-center gap-4">
                            <span class="text-[#c5a059] font-black uppercase tracking-widest text-sm">{{ $article->likes->count() }} J'aime</span>
                            @auth
                                <form action="{{ route('articles.aimer', $article) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="hf-btn-primary py-1 px-4 text-[10px]">
                                        Liker
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <div class="flex items-center gap-4 border-l border-[#c5a059]/20 pl-8">
                            <span class="text-gray-500 font-black uppercase tracking-widest text-[10px]">Partager</span>
                            <div class="flex gap-2">
                                @php
                                    $shareUrl = urlencode(url()->current());
                                    $shareText = urlencode($article->title);
                                @endphp
                                <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}" target="_blank" class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center text-[#c5a059] hover:bg-[#c5a059] hover:text-[#0a0a0a] transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center text-[#c5a059] hover:bg-[#c5a059] hover:text-[#0a0a0a] transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="w-8 h-8 border border-[#c5a059]/30 flex items-center justify-center text-[#c5a059] hover:bg-[#c5a059] hover:text-[#0a0a0a] transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.319 1.592 5.548 0 10.064-4.516 10.066-10.066.002-5.548-4.516-10.064-10.067-10.064-2.692 0-5.222 1.05-7.127 2.955-1.905 1.905-2.953 4.434-2.954 7.125 0 2.061.565 3.593 1.58 5.305l-.911 3.325 3.414-.897zm11.367-7.629c-.33-.164-1.952-.964-2.251-1.074s-.519-.164-.739.164-.853 1.074-1.046 1.293-.385.247-.715.083c-.33-.165-1.393-.513-2.653-1.637-1.033-.873-1.635-2.126-1.838-2.456s-.022-.509.142-.673c.149-.147.33-.384.495-.577s.22-.33.33-.55.055-.412-.028-.577-.739-1.786-1.013-2.446c-.267-.643-.539-.557-.739-.567s-.412-.011-.633-.011-.577.083-.88.412-1.155 1.128-1.155 2.75 1.182 3.19 1.348 3.41 2.326 3.55 5.635 4.984c.786.34 1.4.544 1.877.696.79.25 1.509.215 2.078.13.634-.094 1.952-.798 2.227-1.568s.275-1.43.192-1.568-.302-.247-.633-.411z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('blog.index', [$article->user->id, 'tag' => $tag->id]) }}" class="text-[10px] uppercase font-bold tracking-widest text-gray-500 hover:text-[#c5a059] transition">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Commentaires -->
                <section id="comments" x-data="{ replyTo: null }">
                    <h3 class="text-3xl font-black hf-title italic mb-8">Espace de discussion</h3>

                    @auth
                        <form action="{{ route('commentaires.publier', $article) }}" method="POST" class="mb-12">
                            @csrf
                            <div class="relative">
                                <textarea id="comment-textarea" name="content" rows="4" class="w-full bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 placeholder-gray-600 font-bold tracking-widest text-sm p-4" placeholder="Votre message ici..."></textarea>
                                <button type="button" id="emoji-trigger" class="absolute right-4 bottom-4 text-2xl hover:scale-110 transition opacity-70 hover:opacity-100">😊</button>
                            </div>
                            <button type="submit" class="mt-4 hf-btn-primary">Envoyer le message</button>
                        </form>
                    @else
                        <div class="hf-card p-6 text-center mb-12">
                            <p class="text-gray-500 italic uppercase tracking-widest text-xs">Connectez-vous pour rejoindre la discussion.</p>
                        </div>
                    @endauth

                    <div class="space-y-8">
                        @forelse($article->comments as $comment)
                            <div class="bg-[#111] border-l-4 border-[#c5a059] p-6 shadow-2xl">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-[#c5a059] flex items-center justify-center font-bold text-[#0a0a0a] text-xs mr-3">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-[#c5a059] font-black uppercase tracking-widest text-xs">{{ $comment->user->name }}</span>
                                            <span class="text-gray-600 text-[10px] font-bold uppercase tracking-widest ml-4">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        @auth
                                            <button @click="replyTo = (replyTo === {{ $comment->id }} ? null : {{ $comment->id }})" class="text-[#c5a059] hover:text-white transition font-black uppercase text-[10px] tracking-widest">Répondre</button>

                                            @if($comment->user_id === Auth::id() || $article->user_id === Auth::id())
                                                <form action="{{ route('commentaires.supprimer', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-800 hover:text-red-500 transition font-black uppercase text-[10px] tracking-widest">Supprimer</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <p class="text-gray-300 text-sm leading-relaxed mb-4">{{ $comment->content }}</p>

                                <!-- Formulaire de réponse -->
                                @auth
                                    <div x-show="replyTo === {{ $comment->id }}" x-cloak class="mt-4 mb-6 pl-6 border-l border-[#c5a059]/30">
                                        <form action="{{ route('commentaires.publier', $article) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="relative">
                                                <textarea name="content" rows="3" class="w-full bg-[#0a0a0a] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 placeholder-gray-600 font-bold tracking-widest text-xs p-3" placeholder="Votre réponse à {{ $comment->user->name }}..."></textarea>
                                                <button type="button" class="reply-emoji-trigger absolute right-2 bottom-2 text-xl opacity-50 hover:opacity-100 hover:scale-110 transition">😊</button>
                                            </div>
                                            <div class="mt-2 flex gap-3">
                                                <button type="submit" class="hf-btn-primary py-1 px-4 text-[10px]">Envoyer</button>
                                                <button type="button" @click="replyTo = null" class="text-gray-500 font-black uppercase text-[10px] tracking-widest hover:text-white">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                @endauth

                                <!-- Réponses imbriquées -->
                                @if($comment->replies->count() > 0)
                                    <div class="mt-6 ml-4 md:ml-8 space-y-4 border-l border-[#c5a059]/10 pl-4 md:pl-6">
                                        @foreach($comment->replies as $reply)
                                            <div class="bg-[#0a0a0a]/40 p-4 border border-[#c5a059]/5">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div class="flex items-center">
                                                        <span class="text-[#c5a059] font-black uppercase tracking-widest text-[10px]">{{ $reply->user->name }}</span>
                                                        <span class="text-gray-600 text-[9px] font-bold uppercase tracking-widest ml-3">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @auth
                                                        @if($reply->user_id === Auth::id() || $article->user_id === Auth::id())
                                                            <form action="{{ route('commentaires.supprimer', $reply) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-800 hover:text-red-500 transition font-black uppercase text-[9px] tracking-widest">Supprimer</button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                                <p class="text-gray-400 text-xs leading-relaxed">{{ $reply->content }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-600 italic uppercase tracking-widest text-xs text-center">Aucun commentaire pour le moment.</p>
                        @endforelse
                    </div>
                </section>

                @auth
                @push('scripts')
                <script src="https://unpkg.com/@joeattardi/emoji-button@4.6.4/dist/index.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        if (typeof EmojiButton === 'undefined') return;

                        const picker = new EmojiButton({
                            theme: 'dark',
                            autoHide: true,
                            position: 'top-start'
                        });

                        const mainTrigger = document.querySelector('#emoji-trigger');
                        const mainTextarea = document.querySelector('#comment-textarea');

                        function bindEmoji(trigger, textarea) {
                            if (!trigger || !textarea) return;
                            trigger.addEventListener('click', (e) => {
                                e.preventDefault();
                                picker.off('emoji');
                                picker.on('emoji', selection => {
                                    const start = textarea.selectionStart;
                                    const end = textarea.selectionEnd;
                                    const text = textarea.value;
                                    textarea.value = text.substring(0, start) + selection.emoji + text.substring(end);
                                    textarea.selectionStart = textarea.selectionEnd = start + selection.emoji.length;
                                    textarea.focus();
                                });
                                picker.togglePicker(trigger);
                            });
                        }

                        bindEmoji(mainTrigger, mainTextarea);

                        // Pour les réponses (potentiellement plusieurs)
                        document.querySelectorAll('.reply-emoji-trigger').forEach(btn => {
                            const container = btn.closest('.relative');
                            const txt = container ? container.querySelector('textarea') : null;
                            if (txt) bindEmoji(btn, txt);
                        });
                    });
                </script>
                @endpush
                @endauth
            </div>
        </article>
    </div>
</x-guest-layout>
