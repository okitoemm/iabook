<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Opportunités de projets</h2>
        <div class="flex gap-2">
            <select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                <option>Tous les types</option>
                <option>Urgents</option>
                <option>Cette semaine</option>
                <option>Budget élevé</option>
            </select>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                <option>Toutes les zones</option>
                <option>Paris</option>
                <option>Île-de-France</option>
            </select>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($opportunities ?? [] as $opportunity)
                <li>
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-indigo-600 truncate">
                                    {{ $opportunity->title }}
                                </h3>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $opportunity->city }}
                                    <span class="mx-2">•</span>
                                    {{ $opportunity->budget }}€
                                    @if($opportunity->urgent)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Urgent
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-6 flex items-center space-x-4">
                                <div class="flex flex-col items-end">
                                    <span class="text-sm text-gray-900">{{ $opportunity->created_at->diffForHumans() }}</span>
                                    <span class="text-sm text-gray-500">{{ $opportunity->views_count ?? 0 }} vues</span>
                                </div>
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                    Proposer
                                </button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                {{ Str::limit($opportunity->description, 200) }}
                            </p>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Aucune opportunité disponible pour le moment.</p>
                </li>
            @endforelse
        </ul>

        @if(($opportunities ?? collect())->isNotEmpty())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $opportunities->links() }}
            </div>
        @endif
    </div>
</div>
