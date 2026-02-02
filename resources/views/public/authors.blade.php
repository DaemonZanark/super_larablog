<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-7xl font-black hf-title italic mb-4 tracking-tighter">NOS RÉDACTEURS</h1>
                <p class="text-xl text-[#c5a059] font-bold uppercase tracking-[0.3em]">Ceux qui font vivre le blog</p>
                <div class="w-32 h-1 bg-[#c5a059] mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($authors as $author)
                    <div class="hf-card p-8 text-center group">
                        <div class="relative w-32 h-32 mx-auto mb-6">
                            <div class="absolute inset-0 bg-[#c5a059] rotate-45 group-hover:rotate-90 transition duration-500"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-[#0a0a0a] text-4xl font-black z-10">
                                {{ substr($author->name, 0, 1) }}
                            </div>
                        </div>
                        <h2 class="text-2xl font-black hf-title italic mb-2 tracking-tight group-hover:text-white transition">{{ $author->name }}</h2>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-6">{{ $author->articles_count }} {{ Str::plural('ARTICLE', $author->articles_count) }}</p>
                        <a href="{{ route('blog.index', $author) }}" class="hf-btn-outline text-[10px] py-2 px-6 w-full">Voir les publications</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $authors->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
