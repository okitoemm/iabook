@extends('layouts.app')

@section('title', 'Profil Artisan')

@section('content')
<div class="bg-gray-50">
    <!-- En-tête du profil -->
    <div class="relative bg-indigo-600">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-purple-700 opacity-90"></div>
        
        <!-- Container principal -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Section photo et infos -->
            <div class="flex flex-col items-center sm:items-start sm:flex-row pt-8 pb-16 sm:pb-6">
                <!-- Photo de profil -->
                <div class="relative shrink-0 mb-4 sm:mb-0">
                    <img src="{{ asset('images/artisans/profile-' . ($artisan->id ?? 1) . '.jpg') }}" 
                         alt="Photo profil" 
                         class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl border-4 border-white shadow-lg object-cover">
                    <!-- Badge Vérifié -->
                    <div class="absolute -right-2 -top-2">
                        <span class="flex items-center bg-blue-500 text-white text-xs px-2 py-1 rounded-full shadow-lg">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs">Vérifié</span>
                        </span>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="sm:ml-6 flex-grow text-center sm:text-left">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center justify-center sm:justify-start flex-wrap gap-2">
                        <span>{{ $artisan->name ?? 'Nom de l\'artisan' }}</span>
                        @if($artisan->is_pro ?? false)
                            <span class="inline-block bg-yellow-400 text-xs font-semibold px-2 py-1 rounded-full text-gray-900">PRO</span>
                        @endif
                    </h1>
                    
                    <p class="text-indigo-100 text-sm sm:text-base mt-2">
                        {{ $artisan->profession ?? 'Profession' }} • {{ $artisan->location ?? 'Localisation' }}
                    </p>

                    <!-- Note et avis -->
                    <div class="flex items-center justify-center sm:justify-start mt-3">
                        <div class="flex items-center bg-white bg-opacity-20 px-3 py-1.5 rounded-lg">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-white font-semibold">{{ number_format($artisan->rating ?? 0, 1) }}</span>
                            <span class="ml-1 text-indigo-100">({{ $artisan->reviews_count ?? 0 }} avis)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action - Version mobile -->
            <div class="fixed bottom-0 left-0 right-0 bg-white p-4 shadow-lg sm:hidden z-50">
                <div class="flex gap-2">
                    <button class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                        Contacter
                    </button>
                    <button class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                        Devis
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Actions rapides -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <button class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contacter
                    </button>
                    <button class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Demander un devis
                    </button>
                    <button class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        Sauvegarder
                    </button>
                </div>

                <!-- À propos -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">À propos</h2>
                    <p class="text-gray-600">
                        Plombier qualifié avec plus de 15 ans d'expérience. Spécialisé dans les installations sanitaires, 
                        le dépannage d'urgence et la rénovation de salles de bains. Intervention rapide sur Paris et sa proche banlieue.
                    </p>
                </div>

                <!-- Réalisations -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Réalisations</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @for ($i = 1; $i <= 6; $i++)
                        <div class="relative aspect-square rounded-lg overflow-hidden">
                            <img src="{{ asset('images/artisans/realisations/real-' . $i . '.jpg') }}" 
                                 alt="Réalisation {{ $i }}"
                                 class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Avis -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Avis clients</h2>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">4.8 (127 avis)</span>
                        </div>
                    </div>

                    <!-- Liste des avis -->
                    <div class="space-y-6">
                        @for ($i = 1; $i <= 3; $i++)
                        <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <img src="https://ui-avatars.com/api/?name=Client+{{ $i }}" 
                                         alt="Avatar" 
                                         class="h-8 w-8 rounded-full">
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Client {{ $i }}</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-yellow-400">
                                                @for ($star = 1; $star <= 5; $star++)
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">Il y a 2 jours</span>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Excellent travail, intervention rapide et propre. Je recommande vivement !
                            </p>
                        </div>
                        @endfor
                    </div>

                    <!-- Voir plus d'avis -->
                    <div class="mt-6 text-center">
                        <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Voir tous les avis
                        </button>
                    </div>
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-6">
                <!-- Informations de contact -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">Zone d'intervention</h3>
                                <p class="text-sm text-gray-600">Paris et proche banlieue (92, 93, 94)</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">Horaires</h3>
                                <p class="text-sm text-gray-600">Lun-Ven: 8h-19h<br>Sam: 9h-18h<br>Urgences 24/7</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">Garanties</h3>
                                <ul class="mt-1 text-sm text-gray-600 space-y-1">
                                    <li>• Assurance décennale</li>
                                    <li>• Garantie travaux</li>
                                    <li>• Devis gratuit</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">Moyens de paiement</h3>
                                <p class="text-sm text-gray-600">CB, Espèces, Chèque</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certifications -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Certifications</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center justify-center p-4 border border-gray-200 rounded-lg">
                            <img src="{{ asset('images/certifications/cert-1.png') }}" alt="Certification 1" class="h-12">
                        </div>
                        <div class="flex items-center justify-center p-4 border border-gray-200 rounded-lg">
                            <img src="{{ asset('images/certifications/cert-2.png') }}" alt="Certification 2" class="h-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Boutons d'action - Version desktop -->
<div class="hidden sm:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 flex items-center gap-3">
        <!-- ... boutons existants ... -->
    </div>
</div>
@endsection 