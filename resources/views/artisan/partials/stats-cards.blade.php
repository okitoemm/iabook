<!-- Carte Projets en attente -->
<div class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Projets en attente</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $pendingProjects ?? 0 }}</h3>
        </div>
        <div class="bg-blue-100 rounded-full p-3">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
    </div>
    <div class="mt-4">
        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir tous les projets →</a>
    </div>
</div>

<!-- Carte Chiffre d'affaires -->
<div class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Chiffre d'affaires (mois)</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($monthlyRevenue ?? 0, 2, ',', ' ') }}€</h3>
        </div>
        <div class="bg-green-100 rounded-full p-3">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>
    <div class="mt-2 flex items-center text-sm">
        <span class="text-green-500">+12%</span>
        <span class="text-gray-500 ml-2">vs mois dernier</span>
    </div>
</div>

<!-- Carte Note moyenne -->
<div class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Note moyenne</p>
            <div class="flex items-center mt-1">
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($averageRating ?? 0, 1) }}/5</h3>
                <div class="flex ml-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="h-5 w-5 {{ $i <= ($averageRating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
            </div>
        </div>
        <div class="bg-yellow-100 rounded-full p-3">
            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
        </div>
    </div>
    <div class="mt-2">
        <span class="text-gray-500 text-sm">{{ $totalReviews ?? 0 }} avis</span>
    </div>
</div>

<!-- Carte Taux de conversion -->
<div class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">Taux de conversion</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $conversionRate ?? 0 }}%</h3>
        </div>
        <div class="bg-purple-100 rounded-full p-3">
            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
    </div>
    <div class="mt-2 flex items-center text-sm">
        <span class="text-purple-500">+5%</span>
        <span class="text-gray-500 ml-2">vs mois dernier</span>
    </div>
</div>
