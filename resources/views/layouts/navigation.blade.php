<nav x-data="{ open: false }" class="bg-[#0a0a0a] border-b border-[#c5a059]/30 sticky top-0 z-50 shadow-2xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('accueil') }}" class="hf-title text-2xl italic tracking-tighter">
                        GEEKPLACE
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('accueil')" :active="request()->routeIs('accueil')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                        Accueil
                    </x-nav-link>

                    <x-nav-link :href="route('auteurs.index')" :active="request()->routeIs('auteurs.index')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                        Auteurs
                    </x-nav-link>

                    <x-nav-link :href="route('articles.archives')" :active="request()->routeIs('articles.archives')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                        Archives
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                            Tableau de bord
                        </x-nav-link>

                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                            Mes Articles
                        </x-nav-link>

                        <x-nav-link :href="route('articles.create')" :active="request()->routeIs('articles.create')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                            Écrire
                        </x-nav-link>

                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index') || request()->routeIs('categories.create') || request()->routeIs('categories.edit')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                            Catégories
                        </x-nav-link>

                        <x-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.index') || request()->routeIs('tags.create') || request()->routeIs('tags.edit')" class="text-white hover:text-[#c5a059] uppercase font-bold tracking-widest text-xs">
                            Tags
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @auth
                    <!-- Bouton de téléchargement -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('download.file') }}" class="inline-flex items-center px-3 py-2 border border-[#c5a059]/50 text-xs leading-4 font-bold uppercase tracking-widest text-[#c5a059] bg-transparent hover:text-white hover:border-white hover:bg-[#c5a059] focus:outline-none transition ease-in-out duration-150">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Télécharger le client lourd
                        </a>
                    @endif


                    <!-- Notifications Dropdown -->
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="relative p-2 text-gray-400 hover:text-[#c5a059] transition focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-[#0a0a0a] transform translate-x-1/2 -translate-y-1/2 bg-[#c5a059] rounded-none">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#1a1a1a] border border-[#c5a059]/30 max-h-96 overflow-y-auto">
                                <div class="p-4 border-b border-[#c5a059]/10 flex justify-between items-center bg-[#111]">
                                    <h4 class="text-[10px] font-black uppercase tracking-widest text-[#c5a059]">Notifications</h4>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notifications.read') }}">
                                            @csrf
                                            <button type="submit" class="text-[8px] font-bold uppercase tracking-widest text-gray-500 hover:text-white transition">Tout marquer comme lu</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="divide-y divide-[#c5a059]/10">
                                    @forelse(Auth::user()->notifications->take(10) as $notification)
                                        <div class="p-4 {{ $notification->unread() ? 'bg-[#c5a059]/5' : '' }}">
                                            <p class="text-xs text-gray-300 leading-tight">
                                                @if(isset($notification->data['user_name']))
                                                    <span class="font-black text-[#c5a059]">{{ $notification->data['user_name'] }}</span>
                                                @endif
                                                {!! $notification->data['message'] ?? 'Nouvelle notification' !!}
                                                @if(isset($notification->data['article_title']))
                                                    <span class="italic text-white">"{{ $notification->data['article_title'] }}"</span>
                                                @endif
                                            </p>
                                            <span class="text-[8px] text-gray-600 uppercase font-bold mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center">
                                            <p class="text-[10px] text-gray-600 uppercase font-bold tracking-widest italic">Aucune notification</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-[#c5a059]/50 text-xs leading-4 font-bold uppercase tracking-widest text-[#c5a059] bg-transparent hover:text-white hover:border-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#1a1a1a] border border-[#c5a059]/30">
                                <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-[#c5a059] hover:text-[#0a0a0a]">
                                    Mon Profil
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" class="text-white hover:bg-[#c5a059] hover:text-[#0a0a0a]">
                                        Déconnexion
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-white text-xs font-bold uppercase tracking-widest hover:text-[#c5a059]">Connexion</a>
                        <a href="{{ route('register') }}" class="hf-btn-primary text-xs py-1 px-4">Inscription</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-[#1a1a1a] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#1a1a1a] border-t border-[#c5a059]/20">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('accueil')" :active="request()->routeIs('accueil')" class="text-white">
                Accueil
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('auteurs.index')" :active="request()->routeIs('auteurs.index')" class="text-white">
                Auteurs
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('articles.archives')" :active="request()->routeIs('articles.archives')" class="text-white">
                Archives
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                    Tableau de bord
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')" class="text-white">
                    Mes Articles
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('articles.create')" :active="request()->routeIs('articles.create')" class="text-white">
                    Écrire
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="text-white">
                    Catégories
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.index')" class="text-white">
                    Tags
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')" class="text-white">
                    Connexion
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-white">
                    Inscription
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-[#c5a059]/20">
                <div class="px-4">
                    <div class="font-medium text-base text-[#c5a059]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                        Mon Profil
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="text-white">
                            Déconnexion
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
