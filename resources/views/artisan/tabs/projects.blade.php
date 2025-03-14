<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- En-tête avec filtres -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-900">Mes Projets</h2>
        <div class="flex flex-wrap gap-2">
            <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nouveau Projet
            </button>
        </div>
    </div>

    <!-- Onglets de statut -->
    <div class="mb-6">
        <nav class="flex space-x-4" aria-label="Tabs">
            @foreach(['all' => 'Tous', 'in_progress' => 'En cours', 'pending' => 'En attente', 'completed' => 'Terminés'] as $key => $label)
                <button 
                    @click="currentProjectTab = '{{ $key }}'"
                    :class="{'bg-indigo-100 text-indigo-700': currentProjectTab === '{{ $key }}', 'text-gray-500 hover:text-gray-700': currentProjectTab !== '{{ $key }}'}"
                    class="px-3 py-2 font-medium text-sm rounded-md">
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Liste des projets -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($projects ?? [] as $project)
                <li>
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-indigo-600 truncate">{{ $project->title }}</h3>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        @switch($project->status)
                                            @case('in_progress')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">En cours</span>
                                                @break
                                            @case('pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                                @break
                                            @case('completed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terminé</span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between">
                                    <div class="sm:flex">
                                        <div class="mr-6 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            {{ $project->city }}
                                        </div>
                                        <div class="mt-2 sm:mt-0 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Échéance : {{ $project->deadline?->format('d/m/Y') ?? 'Non définie' }}
                                        </div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($project->budget, 0, ',', ' ') }}€
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Barre de progression -->
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div style="width: {{ $project->progress ?? 0 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                                </div>
                                <div class="flex items-center justify-between text-xs mt-1">
                                    <span class="text-gray-600">Progression</span>
                                    <span class="text-gray-600">{{ $project->progress ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun projet en cours</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par répondre à des opportunités de projets.</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
