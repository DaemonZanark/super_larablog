<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Les Articles publiés
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Article content -->

                    @if ($articles->isEmpty())
                        <p>Aucun article publié pour le moment.</p>
                    @else
                        @foreach ($articles as $article)
                            <div class="mb-6">
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <div class="p-6">
                                        <h2 class="text-xl font-semibold mb-2">{{ $article->title }}</h2>
                                        <p class="text-gray-700 text-base">{{substr($article->content, 0, 50)}}....</p>
                                        <div class="text-left">
                                            <a href="{{ route('articles.edit', $article->id) }}"
                                                class="text-red-500 hover:test-red-700">Modifier
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    <!-- Pagination links -->
                    @isset($article)
                        <div class="mt-4">
                            <a href="{{ route('articles.create') }}" ,
                                class="hover:cursor-pointer text-blue-400 hover:text-red-400 font-semibold">Créer un
                                article</a>
                        </div>
                    @endisset
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>