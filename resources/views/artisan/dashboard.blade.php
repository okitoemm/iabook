<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Artisan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Ajout des styles pour les animations -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Base styles */
        .dashboard-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Mobile first approach */
        .main-content {
            width: 100%;
            padding: 1rem;
            transition: padding-left 0.3s ease;
        }

        .sidebar {
            position: fixed;
            top: 60px; /* Hauteur du header */
            bottom: 0;
            width: 250px;
            z-index: 40;
            transition: transform 0.3s ease;
        }

        /* Responsive breakpoints */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-menu-open {
                overflow: hidden;
            }

            .content-area {
                width: 100%;
            }
        }

        @media (min-width: 769px) {
            .main-content {
                padding-left: 250px;
            }

            .sidebar {
                transform: translateX(0);
            }

            .content-area {
                max-width: calc(100% - 250px);
                margin-left: auto;
            }
        }

        @media (min-width: 1280px) {
            .dashboard-container {
                max-width: 1920px;
                margin: 0 auto;
            }

            .content-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
            }
        }

        /* Animations */
        .fade-enter-active, .fade-leave-active {
            transition: opacity 0.3s ease;
        }

        .content-transition {
            transition: all 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100" x-data="{ 
    sidebarOpen: false, 
    currentTab: window.location.hash ? window.location.hash.replace('#', '') : 'overview',
    isMobile: window.innerWidth < 768,

    init() {
        window.addEventListener('hashchange', () => {
            this.currentTab = window.location.hash.replace('#', '') || 'overview';
        });
    }
}">
    <script>
        function dashboardData() {
            return {
                sidebarOpen: false,
                currentTab: '{{ $currentTab }}', // Utilisation de la variable du contrôleur
                isMobile: window.innerWidth < 768,
                
                init() {
                    this.$watch('isMobile', value => {
                        if (!value) this.sidebarOpen = false;
                    });

                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 768;
                    });
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },

                closeSidebar() {
                    if (this.isMobile) this.sidebarOpen = false;
                }
            }
        }
    </script>

    <div class="dashboard-container">
        <!-- Header fixe -->
        <header class="fixed top-0 w-full bg-white shadow-sm z-50 h-[60px]">
            <div class="px-4 h-full flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="toggleSidebar" 
                            class="md:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="ml-3 text-xl font-semibold text-gray-900">Dashboard</h1>
                </div>

                <!-- Actions rapides -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('projects.available') }}" 
                       class="btn-primary flex items-center">
                        <span class="hidden sm:inline">Missions</span>
                        <span class="sm:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                        @if($newProjectsCount > 0)
                            <span class="ml-1 badge">{{ $newProjectsCount }}</span>
                        @endif
                    </a>

                    <nav class="flex items-center space-x-2">
                        <a href="{{ url('/') }}" class="btn-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Sidebar avec overlay -->
        <aside :class="{'open': sidebarOpen}"
               class="sidebar bg-indigo-700">
            @include('artisan.partials.sidebar-content')
        </aside>

        <!-- Overlay mobile -->
        <div x-show="sidebarOpen && isMobile"
             @click="closeSidebar"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 md:hidden">
        </div>

        <!-- Contenu principal -->
        <main class="main-content pt-[60px]">
            <div class="content-area p-4 sm:p-6 lg:p-8">
                <!-- Overview Tab -->
                <div x-show="currentTab === 'overview'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.overview')
                </div>

                <!-- Projects Tab -->
                <div x-show="currentTab === 'projects'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.projects')
                </div>

                <!-- Messages Tab -->
                <div x-show="currentTab === 'messages'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.messages')
                </div>

                <!-- Calendar Tab -->
                <div x-show="currentTab === 'calendar'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.calendar')
                </div>

                <!-- Reviews Tab -->
                <div x-show="currentTab === 'reviews'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.reviews')
                </div>

                <!-- Analytics Tab -->
                <div x-show="currentTab === 'analytics'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.analytics')
                </div>

                <!-- Settings Tab -->
                <div x-show="currentTab === 'settings'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('artisan.tabs.settings')
                </div>
            </div>
        </main>
    </div>

    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-6">Projets disponibles</h2>
                        
                        <!-- Filtres -->
                        <div class="mb-6 flex gap-4">
                            <select class="rounded-md border-gray-300" x-model="filters.category">
                                <option value="">Toutes catégories</option>
                                <option value="plomberie">Plomberie</option>
                                <option value="electricite">Électricité</option>
                                <option value="maconnerie">Maçonnerie</option>
                                <option value="peinture">Peinture</option>
                            </select>

                            <select class="rounded-md border-gray-300" x-model="filters.city">
                                <option value="">Toutes villes</option>
                                @if(isset($cities))
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                @endif
                            </select>

                            <label class="inline-flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600" x-model="filters.urgent">
                                <span class="ml-2">Urgents uniquement</span>
                            </label>
                        </div>

                        <!-- Liste des projets -->
                        <div class="space-y-6">
                            @foreach($projects as $project)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                                        <p class="text-gray-600">{{ Str::limit($project->description, 150) }}</p>
                                        
                                        <!-- Galerie d'images -->
                                        @if($project->photos)
                                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-2">
                                            @foreach(json_decode($project->photos) as $index => $photo)
                                            @if($index < 4)
                                            <div class="relative aspect-w-4 aspect-h-3">
                                                <img src="{{ $photo }}" 
                                                     alt="Photo du projet" 
                                                     class="object-cover rounded-lg w-full h-full"
                                                     loading="lazy">
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    
                                    @if($project->urgent)
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm flex-shrink-0 ml-4">
                                        Urgent
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                                    <span>{{ $project->city }}</span>
                                    <span>Budget: {{ $project->budget }}€</span>
                                    <span>{{ $project->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('artisan.projects.show', $project) }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>