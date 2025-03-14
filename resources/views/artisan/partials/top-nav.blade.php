<nav class="bg-white shadow-sm" x-data="{ userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left section -->
            <div class="flex items-center">
                <button @click="toggleSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="ml-4 flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                    <span class="ml-2 text-lg font-semibold text-gray-900">Dashboard Artisan</span>
                </div>
            </div>

            <!-- Right section -->
            <div class="flex items-center space-x-4">
                <!-- Quick Actions -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('projects.available') }}" 
                       class="relative inline-flex items-center px-4 py-2 bg-indigo-600 text-sm font-medium text-white rounded-md hover:bg-indigo-700">
                        <span>Nouvelles missions</span>
                        @if($newProjectsCount > 0)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-300 text-indigo-800">
                                {{ $newProjectsCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Profile dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <img class="h-9 w-9 rounded-full object-cover" 
                             src="{{ auth()->user()->profile_photo_url }}" 
                             alt="{{ auth()->user()->name }}">
                        <span class="hidden md:block text-sm font-medium text-gray-700">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <div class="py-1" role="menu">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                            <a href="{{ route('artisan.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
