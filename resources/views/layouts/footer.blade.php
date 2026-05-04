<footer class="bg-[#050505] border-t border-[#c5a059]/20 pt-12 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('accueil') }}" class="text-3xl font-bold hf-title mb-4 block italic">GEEKPLACE</a>
                <p class="text-gray-400 max-w-md">
                    Inspiré par l'esprit du plus grand festival de metal. Partagez vos passions, vos critiques et vos découvertes musicales sur une plateforme dédiée à la culture alternative.
                </p>
            </div>
            <div>
                <h4 class="text-[#c5a059] font-bold uppercase mb-4 tracking-widest">Navigation</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('accueil') }}" class="text-gray-400 hover:text-[#c5a059] transition">Accueil</a></li>
                    <li><a href="{{ route('auteurs.index') }}" class="text-gray-400 hover:text-[#c5a059] transition">Auteurs</a></li>
                    <li><a href="{{ route('articles.archives') }}" class="text-gray-400 hover:text-[#c5a059] transition">Archives</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-[#c5a059] transition">Connexion</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#c5a059] transition">Tableau de bord</a></li>
                    @endguest
                </ul>
            </div>
            <div>
                <h4 class="text-[#c5a059] font-bold uppercase mb-4 tracking-widest">Contact</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Email: contact@larablog.fr</li>
                    <li>L'Espace des Mots</li>
                </ul>
                <div class="flex space-x-4 mt-6">
                    <a href="#" class="text-gray-400 hover:text-[#c5a059]"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#c5a059]"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#c5a059]"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-[#c5a059]/10 pt-8 text-center text-xs text-gray-500 uppercase tracking-widest">
            &copy; {{ date('Y') }} GEEKPLACE. ALL RIGHTS RESERVED. BEYOND THE BLOG.
        </div>
    </div>
</footer>
