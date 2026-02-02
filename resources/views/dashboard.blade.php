<x-app-layout>
    <x-slot name="header">
        ESPACE RÉDACTION
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Stats Cards -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="hf-card p-8 relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 text-8xl text-white/5 font-black uppercase italic group-hover:scale-110 transition duration-500">BLOG</div>
                        <div class="relative z-10">
                            <div class="text-[#c5a059] text-xs font-black uppercase tracking-[0.2em] mb-2">Articles publiés</div>
                            <div class="text-5xl font-black hf-title italic tracking-tighter">{{ $totalArticles }}</div>
                        </div>
                    </div>
                    <div class="hf-card p-8 relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 text-8xl text-white/5 font-black uppercase italic group-hover:scale-110 transition duration-500">AIME</div>
                        <div class="relative z-10">
                            <div class="text-[#c5a059] text-xs font-black uppercase tracking-[0.2em] mb-2">J'aime reçus</div>
                            <div class="text-5xl font-black hf-title italic tracking-tighter">{{ $sommeLikes }}</div>
                        </div>
                    </div>
                    <div class="hf-card p-8 relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 text-8xl text-white/5 font-black uppercase italic group-hover:scale-110 transition duration-500">COMS</div>
                        <div class="relative z-10">
                            <div class="text-[#c5a059] text-xs font-black uppercase tracking-[0.2em] mb-2">Commentaires</div>
                            <div class="text-5xl font-black hf-title italic tracking-tighter">{{ $sommeCommentaires }}</div>
                        </div>
                    </div>
                </div>

                <!-- Graphique -->
                <div class="lg:col-span-2">
                    <div class="hf-card p-8 h-full">
                        <h3 class="text-[#c5a059] font-black uppercase tracking-widest text-xs mb-8 border-b border-[#c5a059]/20 pb-4">Activité des 7 derniers jours</h3>
                        <div class="h-[300px]">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('activityChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @js($dates),
                            datasets: [{
                                label: 'Likes',
                                data: @js($donneesLikes),
                                borderColor: '#c5a059',
                                backgroundColor: 'rgba(197, 160, 89, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4
                            }, {
                                label: 'Commentaires',
                                data: @js($donneesCommentaires),
                                borderColor: '#ffffff',
                                backgroundColor: 'rgba(255, 255, 255, 0.05)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#666',
                                        font: {
                                            family: 'Figtree',
                                            weight: 'bold',
                                            size: 10
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(197, 160, 89, 0.05)'
                                    },
                                    ticks: {
                                        color: '#666',
                                        stepSize: 1
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#666'
                                    }
                                }
                            }
                        }
                    });
                });
            </script>

            <div class="hf-card overflow-hidden">
                <div class="p-8 border-b border-[#c5a059]/20 flex justify-between items-center">
                    <h3 class="text-2xl font-black hf-title italic">DERNIÈRES PUBLICATIONS</h3>
                    <a href="{{ route('articles.create') }}" class="hf-btn-primary text-[10px]">Nouvel Article</a>
                </div>
                <div class="p-0">
                    @if($articlesRecents->isEmpty())
                        <div class="p-12 text-center text-gray-500 uppercase tracking-widest text-xs italic">
                            Aucun article rédigé pour le moment.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-[#111] border-b border-[#c5a059]/10">
                                    <tr>
                                        <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-[#c5a059]">Titre</th>
                                        <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-[#c5a059]">Date</th>
                                        <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-[#c5a059]">Statut</th>
                                        <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-[#c5a059] text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#c5a059]/5">
                                    @foreach($articlesRecents as $article)
                                        <tr class="hover:bg-white/5 transition">
                                            <td class="px-8 py-4 font-bold italic text-white">{{ $article->title }}</td>
                                            <td class="px-8 py-4 text-xs font-bold uppercase text-gray-500">{{ $article->created_at->format('d/m/Y') }}</td>
                                            <td class="px-8 py-4">
                                                @if($article->draft)
                                                    <span class="border border-yellow-800 text-yellow-600 text-[9px] font-black px-2 py-0.5 uppercase tracking-tighter">Brouillon</span>
                                                @else
                                                    <span class="border border-[#c5a059] text-[#c5a059] text-[9px] font-black px-2 py-0.5 uppercase tracking-tighter">Publié</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-4 text-right space-x-4">
                                                <a href="{{ route('articles.edit', $article) }}" class="text-[#c5a059] hover:text-white text-[10px] font-black uppercase tracking-widest">Modifier</a>
                                                <a href="{{ route('blog.article', [Auth::user(), $article]) }}" target="_blank" class="text-white hover:text-[#c5a059] text-[10px] font-black uppercase tracking-widest">Voir</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 bg-[#050505] text-center">
                            <a href="{{ route('articles.index') }}" class="text-gray-500 hover:text-[#c5a059] text-[10px] font-black uppercase tracking-widest transition">Gérer toutes mes publications &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
