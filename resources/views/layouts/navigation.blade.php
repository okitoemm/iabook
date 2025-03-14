<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">ArtisanPro</a>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="text-gray-700 hover:text-indigo-600">Trouver un artisan</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600">Publier un projet</a>
                @auth
                    <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-gray-900">Messages</a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="Profile" class="h-8 w-8 rounded-full">
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="{{ auth()->user()->isArtisan() ? route('artisan.dashboard') : route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tableau de bord</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Connexion</a>
                    <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Inscription</a>
                @endauth
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @auth
                    <x-nav-link :href="route('settings.show')" :active="request()->routeIs('settings.*')" class="flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ __('Paramètres') }}</span>
                    </x-nav-link>

                    @if(auth()->user()->isArtisan())
                        <x-nav-link :href="route('artisan.dashboard')" :active="request()->routeIs('artisan.dashboard')">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="mobileMenu = !mobileMenu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'inline-flex': !mobileMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenu, 'inline-flex': mobileMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenu" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Trouver un artisan</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Publier un projet</a>
            @auth
                <a href="{{ route('messages.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Messages</a>
                <a href="{{ auth()->user()->isArtisan() ? route('artisan.dashboard') : route('client.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Tableau de bord</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Connexion</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Inscription</a>
            @endauth
        </div>
    </div>
</nav>