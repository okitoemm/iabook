@extends('layouts.app')

@section('content')
    <!-- Hero Section avec image -->
    <div class="relative bg-gradient-to-r from-gray-50 to-gray-100 overflow-hidden py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Badge Vérifié Laravel -->
                <div class="absolute top-4 left-4 z-20">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Artisans Vérifiés 
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[400px] sm:min-h-[450px] lg:min-h-[500px]">
                    <!-- Contenu texte -->
                    <div class="relative z-10 bg-white lg:max-w-2xl lg:w-full p-6 sm:p-8 lg:p-12 flex items-center">
                        <div class="text-center lg:text-left max-w-lg mx-auto lg:mx-0">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-gray-900">
                                <span class="block animate-pulse-slow">Trouvez l'artisan idéal</span>
                                <span class="block text-indigo-600 mt-2 animate-pulse-slow delay-300">pour vos projets</span>
                            </h1>
                            <p class="mt-4 sm:mt-6 text-base sm:text-lg lg:text-xl text-gray-500 max-w-3xl">
                                Des milliers d'artisans qualifiés prêts à réaliser vos projets.
                            </p>
                            <div class="mt-6 sm:mt-8 flex justify-center lg:justify-start">
                                <a href="#" class="inline-flex items-center px-6 py-3 sm:px-8 sm:py-4 border border-transparent text-base sm:text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                                    Commencer
                                    <svg class="ml-2 h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="relative h-full">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-indigo-100 opacity-20"></div>
                        <img class="absolute inset-0 w-full h-full object-cover" 
                             src="{{ asset('images/hero/artisanhero.jpg') }}" 
                             alt="Artisan au travail">
                        <!-- Overlay décoratif -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="relative border-t border-gray-100">
                    <div class="grid grid-cols-2 sm:grid-cols-3 divide-x divide-gray-200">
                        <div class="p-4 sm:p-6 text-center">
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">2000+</div>
                            <div class="text-xs sm:text-sm lg:text-base text-gray-600 mt-1">Artisans vérifiés</div>
                        </div>
                        <div class="p-4 sm:p-6 text-center">
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">4.8/5</div>
                            <div class="text-xs sm:text-sm lg:text-base text-gray-600 mt-1">Note moyenne</div>
                        </div>
                        <div class="hidden sm:block p-4 sm:p-6 text-center">
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">24/7</div>
                            <div class="text-xs sm:text-sm lg:text-base text-gray-600 mt-1">Support client</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Recherche Unifiée -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Barre de recherche principale -->
            <div class="p-6 border-b border-gray-100">
                <div class="relative">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Champ de recherche principal -->
                        <div class="flex-grow relative">
                            <input type="text" 
                                   placeholder="Rechercher un artisan, un métier..." 
                                   class="w-full pl-12 pr-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="relative w-full sm:w-72">
                            <input type="text" 
                                   placeholder="Ville ou code postal"
                                   class="w-full pl-10 pr-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Bouton Rechercher -->
                        <button class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                            <span>Rechercher</span>
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Suggestions de recherche -->
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        <span class="font-medium">Suggestions :</span>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="hover:text-indigo-600 bg-gray-50 px-3 py-1 rounded-full hover:bg-indigo-50 transition-colors duration-200">Plombier Paris</a>
                            <a href="#" class="hover:text-indigo-600 bg-gray-50 px-3 py-1 rounded-full hover:bg-indigo-50 transition-colors duration-200">Électricien urgence</a>
                            <a href="#" class="hover:text-indigo-600 bg-gray-50 px-3 py-1 rounded-full hover:bg-indigo-50 transition-colors duration-200">Peintre décorateur</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres avancés -->
            <div class="px-6 py-4 bg-gray-50 flex flex-wrap items-center gap-4" x-data="{ showFilters: false }">
                <!-- Filtres principaux -->
                <div class="flex flex-wrap items-center gap-2">
                    <button class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-full hover:border-indigo-500 hover:text-indigo-600 flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filtres</span>
                    </button>
                    <button class="px-4 py-2 text-sm bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200">PRO</button>
                    <button class="px-4 py-2 text-sm bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200">Vérifié</button>
                    <button class="px-4 py-2 text-sm bg-green-100 text-green-700 rounded-full hover:bg-green-200">Disponible</button>
                </div>

                <!-- Filtres rapides -->
                <div class="flex flex-wrap gap-2 ml-auto">
                    <button class="px-3 py-1 text-sm border border-gray-200 rounded-full hover:border-indigo-500 hover:text-indigo-600 bg-white">
                        Devis gratuit
                    </button>
                    <button class="px-3 py-1 text-sm border border-gray-200 rounded-full hover:border-indigo-500 hover:text-indigo-600 bg-white">
                        Intervention urgente
                    </button>
                    <button class="px-3 py-1 text-sm border border-gray-200 rounded-full hover:border-indigo-500 hover:text-indigo-600 bg-white">
                        Assurance décennale
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Artisans Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Artisans à la une</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @for ($i = 1; $i <= 8; $i++)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-all duration-300">
                <!-- Badge PRO -->
                <div class="absolute top-2 sm:top-4 right-2 sm:right-4 z-10">
                    <span class="px-2 py-1 bg-yellow-400 text-white text-xs font-semibold rounded-full shadow-lg">
                        PRO
                    </span>
                </div>
                
                <div class="relative">
                    <img src="{{ asset('images/artisans/artisan-' . $i . '.jpg') }}" 
                         alt="Artisan {{ $i }}" 
                         class="w-full h-40 sm:h-48 object-cover">
                    <!-- Badge Vérifié -->
                    <div class="absolute bottom-2 right-2">
                        <span class="flex items-center bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Vérifié
                        </span>
                    </div>
                </div>

                <div class="p-3 sm:p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">Artisan Pro {{$i}}</h3>
                        <div class="flex items-center shrink-0">
                            <svg class="h-4 sm:h-5 w-4 sm:w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-sm sm:text-base text-gray-600">4.8</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500 mb-3">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="truncate">Paris, France</span>
                        </div>

                        <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="truncate">Plomberie</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
                        <span class="text-sm sm:text-base text-indigo-600 font-semibold">À partir de 50€/h</span>
                        <a href="{{ route('artisans.show', ['id' => $i]) }}" 
                           class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white text-center rounded-md hover:bg-indigo-700 transform hover:scale-105 transition-all duration-200">
                            Contacter
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Bouton Voir plus -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 text-center">
        <button class="group inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200">
            Voir plus d'artisans
            <svg class="ml-2 h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
        <p class="mt-2 text-sm text-gray-500">Découvrez plus de 1000 artisans qualifiés dans votre région</p>
    </div>

    <!-- Categories Section -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Catégories populaires</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="font-semibold text-gray-900">Plomberie</h3>
                    <p class="text-sm text-gray-600">Plus de 500 artisans</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="font-semibold text-gray-900">Électricité</h3>
                    <p class="text-sm text-gray-600">Plus de 400 artisans</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="font-semibold text-gray-900">Maçonnerie</h3>
                    <p class="text-sm text-gray-600">Plus de 300 artisans</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="font-semibold text-gray-900">Peinture</h3>
                    <p class="text-sm text-gray-600">Plus de 600 artisans</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Avis Google -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center mb-12">
                <img src="{{ asset('images/logos/logo-google.jpg') }}" alt="Google" class="h-8">
                <div class="ml-4">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold">4.5</span>
                        <div class="flex ml-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600">234 avis</p>
                </div>
            </div>

            <!-- Carrousel d'avis -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials ?? [] as $testimonial)
                <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-4">
                        <img src="{{ $testimonial['avatar'] }}" alt="Avatar" class="h-12 w-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="font-semibold">{{ $testimonial['name'] }}</h4>
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">{{ $testimonial['comment'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Voir plus d'avis
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    

    <!-- Ajout des styles pour x-cloak -->
    <style>
        @keyframes pulse-slow {
            0%, 100% {
                opacity: 1;
                transform: translateY(0);
            }
            50% {
                opacity: 0.95;
                transform: translateY(-5px);
            }
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 0.3s ease-in-out infinite;
        }
        
        .delay-300 {
            animation-delay: 100ms;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>
</html>
@endsection
