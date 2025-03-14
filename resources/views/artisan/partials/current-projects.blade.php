<div class="space-y-4">
    @forelse($currentProjects ?? [] as $project)
        <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-medium text-gray-900">{{ $project->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $project->client->name }}</p>
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="text-sm text-gray-500">
                            <svg class="inline-block h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $project->city }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <svg class="inline-block h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $project->deadline ? $project->deadline->format('d/m/Y') : 'Non spécifiée' }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @switch($project->status)
                        @case('in_progress')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">En cours</span>
                            @break
                        @case('pending')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                            @break
                        @case('completed')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Terminé</span>
                            @break
                    @endswitch
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Voir les détails</a>
                    <span class="text-gray-300">|</span>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Contact client</a>
                </div>
                <div class="text-sm font-medium text-gray-900">
                    {{ number_format($project->budget, 0, ',', ' ') }}€
                </div>
            </div>
            <!-- Barre de progression -->
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                </div>
                <div class="mt-1 text-xs text-gray-500 text-right">{{ $project->progress ?? 0 }}% complété</div>
            </div>
        </div>
    @empty
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun projet en cours</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par répondre aux opportunités disponibles.</p>
        </div>
    @endforelse
</div>
