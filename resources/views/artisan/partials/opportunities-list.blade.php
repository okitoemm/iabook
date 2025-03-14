<div x-data="{ selectedOpportunity: null }" class="overflow-hidden">
    <!-- Filtres rapides -->
    <div class="flex flex-wrap gap-2 mb-4">
        <button class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200 text-sm">
            Tous les projets
        </button>
        <button class="px-3 py-1 bg-red-100 text-red-700 rounded-full hover:bg-red-200 text-sm">
            Urgent
        </button>
        <button class="px-3 py-1 bg-green-100 text-green-700 rounded-full hover:bg-green-200 text-sm">
            Proche de vous
        </button>
        <button class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full hover:bg-yellow-200 text-sm">
            Budget élevé
        </button>
    </div>

    <!-- Liste des opportunités -->
    <div class="space-y-4">
        @forelse($opportunities ?? [] as $opportunity)
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                 x-data="{ showDetails: false }">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $opportunity->title }}</h3>
                        <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $opportunity->city }}
                            </span>
                            <span>•</span>
                            <span>{{ $opportunity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @if($opportunity->urgent)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Urgent
                        </span>
                    @endif
                </div>

                <div class="mt-2">
                    <p x-show="!showDetails" class="text-gray-600">
                        {{ Str::limit($opportunity->description, 150) }}
                    </p>
                    <p x-show="showDetails" class="text-gray-600">
                        {{ $opportunity->description }}
                    </p>
                    @if(strlen($opportunity->description) > 150)
                        <button @click="showDetails = !showDetails" 
                                class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                            <span x-text="showDetails ? 'Voir moins' : 'Voir plus'"></span>
                        </button>
                    @endif
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="inline-flex items-center text-sm font-medium text-gray-900">
                            <svg class="h-5 w-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            {{ number_format($opportunity->budget, 0, ',', ' ') }}€
                        </span>
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Date limite: {{ $opportunity->deadline ? $opportunity->deadline->format('d/m/Y') : 'Non spécifiée' }}
                        </span>
                    </div>
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Proposer mes services
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune opportunité pour le moment</h3>
                <p class="mt-1 text-sm text-gray-500">Les nouvelles opportunités apparaîtront ici.</p>
                <div class="mt-6">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Configurer mes préférences de projets
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>
