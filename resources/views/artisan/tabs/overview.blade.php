<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- En-tête avec stats rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-indigo-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Projets en cours</p>
                    <h3 class="font-semibold text-xl">{{ $stats['ongoing_projects'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Chiffre d'affaires</p>
                    <h3 class="font-semibold text-xl">{{ number_format($stats['monthly_revenue'] ?? 0, 0, ',', ' ') }}€</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Note moyenne</p>
                    <h3 class="font-semibold text-xl">{{ number_format($stats['rating_average'] ?? 0, 1) }}/5</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Vues du profil</p>
                    <h3 class="font-semibold text-xl">{{ $stats['profile_views'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- ... Autres actions rapides ... -->
        </div>
    </div>

    <!-- Dernières notifications -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Dernières notifications</h2>
            <div class="space-y-4">
                @forelse($notifications ?? [] as $notification)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <!-- Icône selon le type de notification -->
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                            <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Aucune nouvelle notification</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
