<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Missions disponibles</h1>
            <a href="{{ route('artisan.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        <div class="bg-white shadow rounded-lg">
            @forelse($projects as $project)
                <div class="border-b border-gray-200 p-6 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $project->title }}</h3>
                            <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $project->city }}
                                </span>
                                <span>•</span>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                                @if($project->budget)
                                    <span>•</span>
                                    <span>Budget: {{ number_format($project->budget, 0, ',', ' ') }}€</span>
                                @endif
                            </div>
                        </div>
                        @if($project->urgent)
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                Urgent
                            </span>
                        @endif
                    </div>
                    <p class="mt-3 text-gray-600">{{ Str::limit($project->description, 200) }}</p>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('projects.show', $project) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                            Voir les détails
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune mission disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Les nouvelles missions apparaîtront ici.</p>
                </div>
            @endforelse

            @if($projects->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
