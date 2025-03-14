<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtres -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <form action="{{ route('projects.feed') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rechercher</label>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                            placeholder="Mots clés...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                        <select name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" @selected($filters['city'] ?? '' == $city)>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="text" name="postal_code" value="{{ $filters['postal_code'] ?? '' }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                            placeholder="Code postal">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des projets -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300"
                         x-data="{ show: false }"
                         @mouseenter="show = true"
                         @mouseleave="show = false">
                        
                        @if($project->media->isNotEmpty())
                            <img src="{{ $project->media->first()->getUrl() }}" 
                                 alt="{{ $project->title }}"
                                 class="w-full h-48 object-cover">
                        @endif

                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $project->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                            
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>{{ $project->city }}</span>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                            </div>

                            <div x-show="show" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-90"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 class="mt-4">
                                <a href="{{ route('projects.show', $project) }}" 
                                   class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Voir le détail
                                </a>
                            </div>
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
</x-app-layout>
