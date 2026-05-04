<x-app-layout>
    <x-slot name="header">
        RÉDACTION D'UN ARTICLE
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <form method="post" action="{{ route('articles.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="hf-card p-8 space-y-6">
                <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-sm border-b border-[#c5a059]/20 pb-4">Informations Générales</h3>

                <div>
                    <label for="title" class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Titre de l'article</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 font-bold tracking-widest text-sm" placeholder="Saisissez le titre...">
                    @error('title') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Image de couverture</label>
                    <input type="file" name="image" id="image" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-[#c5a059] file:text-[#0a0a0a] hover:file:bg-[#e0bc7a] cursor-pointer">
                    @error('image') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Catégories</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto p-4 bg-[#0a0a0a] border border-[#c5a059]/20 scrollbar-thin scrollbar-thumb-[#c5a059]/50 scrollbar-track-transparent">
                            @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'checked' : '' }} class="peer w-4 h-4 bg-[#111] border-[#c5a059]/30 text-[#c5a059] focus:ring-0 rounded-none cursor-pointer appearance-none checked:bg-[#c5a059] border transition-colors">
                                        <svg class="w-3 h-3 absolute left-0.5 pointer-events-none hidden peer-checked:block text-[#0a0a0a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="ml-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-[#c5a059] peer-checked:text-[#c5a059] transition">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Tags</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto p-4 bg-[#0a0a0a] border border-[#c5a059]/20 scrollbar-thin scrollbar-thumb-[#c5a059]/50 scrollbar-track-transparent">
                            @foreach($tags as $tag)
                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'checked' : '' }} class="peer w-4 h-4 bg-[#111] border-[#c5a059]/30 text-[#c5a059] focus:ring-0 rounded-none cursor-pointer appearance-none checked:bg-[#c5a059] border transition-colors">
                                        <svg class="w-3 h-3 absolute left-0.5 pointer-events-none hidden peer-checked:block text-[#0a0a0a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="ml-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-[#c5a059] peer-checked:text-[#c5a059] transition">#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tags') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="hf-card p-8 space-y-6">
                <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-sm border-b border-[#c5a059]/20 pb-4">Le Corps de l'Article</h3>

                <div>
                    <label for="content" class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Contenu</label>
                    <textarea name="content" id="content" rows="15" class="w-full bg-[#111] border-[#c5a059]/30 text-white focus:border-[#c5a059] focus:ring-0 font-bold tracking-widest text-sm leading-relaxed p-6" placeholder="Libérez votre créativité...">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-600 text-[10px] mt-1 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="hf-card p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center">
                    <input type="checkbox" name="draft" id="draft" {{ old('draft') ? 'checked' : '' }} class="w-5 h-5 bg-[#111] border-[#c5a059]/30 text-[#c5a059] focus:ring-0 rounded-none cursor-pointer">
                    <label for="draft" class="ml-3 text-xs font-black uppercase tracking-widest text-[#c5a059] cursor-pointer">Enregistrer comme brouillon</label>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('articles.index') }}" class="hf-btn-outline py-2 px-8">Annuler</a>
                    <button type="submit" class="hf-btn-primary py-2 px-8">Publier l'article</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
