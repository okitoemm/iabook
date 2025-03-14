<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- En-tête avec statistiques -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Avis Clients</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Note moyenne</h3>
                        <p class="text-xl font-semibold">{{ number_format($stats['rating_average'] ?? 0, 1) }}/5</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Total avis</h3>
                        <p class="text-xl font-semibold">{{ $stats['total_reviews'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Avis positifs</h3>
                        <p class="text-xl font-semibold">{{ $stats['positive_reviews_percentage'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Vues du profil</h3>
                        <p class="text-xl font-semibold">{{ $stats['profile_views'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des avis -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Avis récents</h3>
            <div class="flex items-center space-x-4">
                <select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                    <option value="all">Tous les avis</option>
                    <option value="positive">Avis positifs</option>
                    <option value="negative">Avis négatifs</option>
                </select>
            </div>
        </div>

        <ul class="divide-y divide-gray-200">
            @forelse($reviews ?? [] as $review)
                <li class="p-4 hover:bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $review->client->profile_photo_url }}" alt="">
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-gray-900">{{ $review->client->name }}</h4>
                                <time class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</time>
                            </div>
                            <div class="mt-1 flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="mt-2 text-sm text-gray-700">{{ $review->comment }}</p>
                            @if($review->photos)
                                <div class="mt-2 flex space-x-2">
                                    @foreach($review->photos as $photo)
                                        <img src="{{ $photo }}" alt="Photo review" class="h-20 w-20 object-cover rounded">
                                    @endforeach
                                </div>
                            @endif
                            @if($review->project)
                                <div class="mt-2 text-sm">
                                    <span class="text-gray-500">Projet : </span>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">{{ $review->project->title }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Options</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun avis pour le moment</h3>
                        <p class="mt-1 text-sm text-gray-500">Les avis de vos clients apparaîtront ici.</p>
                    </div>
                </li>
            @endforelse
        </ul>

        <!-- Pagination -->
        @if($reviews instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
