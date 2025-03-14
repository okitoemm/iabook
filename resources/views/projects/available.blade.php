<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total Projets</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Projets Urgents</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['urgent'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Budget Moyen</h3>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($stats['avg_budget'], 2) }}€</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Par Catégorie</h3>
                    <div class="text-sm">
                        @foreach($stats['by_category'] as $category => $count)
                            <div class="flex justify-between">
                                <span>{{ ucfirst($category) }}</span>
                                <span class="font-semibold">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Projets disponibles</h2>
                    
                    <!-- Filtres -->
                    <div class="mb-6 flex gap-4">
                        <select name="category" class="rounded-md border-gray-300">
                            <option value="">Toutes catégories</option>
                            <option value="plomberie">Plomberie</option>
                            <option value="electricite">Électricité</option>
                            <option value="maconnerie">Maçonnerie</option>
                            <option value="peinture">Peinture</option>
                        </select>

                        <select name="city" class="rounded-md border-gray-300">
                            <option value="">Toutes villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>

                        <label class="inline-flex items-center">
                            <input type="checkbox" name="urgent" class="rounded border-gray-300 text-indigo-600">
                            <span class="ml-2">Urgents uniquement</span>
                        </label>
                    </div>

                    <!-- Liste des projets -->
                    <div class="space-y-6">
                        @forelse($projects as $project)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                                        <p class="text-gray-600">{{ Str::limit($project->description, 150) }}</p>
                                    </div>
                                    @if($project->urgent)
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Urgent</span>
                                    @endif
                                </div>
                                
                                <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                                    <span>{{ $project->city }}</span>
                                    <span>Budget: {{ $project->budget }}€</span>
                                    <span>{{ $project->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('projects.show', $project) }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Aucun projet disponible pour le moment.</p>
                        @endforelse
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
