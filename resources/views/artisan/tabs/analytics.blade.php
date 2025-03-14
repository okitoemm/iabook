<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <!-- En-tête avec sélecteur de période -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Statistiques et Analyses</h2>
        <div class="flex items-center space-x-4">
            <select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                <option value="7">7 derniers jours</option>
                <option value="30">30 derniers jours</option>
                <option value="90">3 derniers mois</option>
                <option value="365">Cette année</option>
            </select>
            <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter
            </button>
        </div>
    </div>

    <!-- Cartes de statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Chiffre d'affaires -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Chiffre d'affaires</h3>
                <span class="text-green-500 text-sm font-medium">+12.5%</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }}€</p>
            <div class="mt-4 h-16">
                <!-- Mini graphique à insérer ici -->
            </div>
        </div>

        <!-- Taux de conversion -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Taux de conversion</h3>
                <span class="text-green-500 text-sm font-medium">+5.2%</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['conversion_rate'] ?? 0 }}%</p>
            <div class="mt-4 h-16">
                <!-- Mini graphique à insérer ici -->
            </div>
        </div>

        <!-- Projets complétés -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Projets complétés</h3>
                <span class="text-green-500 text-sm font-medium">+8.1%</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['completed_projects'] ?? 0 }}</p>
            <div class="mt-4 h-16">
                <!-- Mini graphique à insérer ici -->
            </div>
        </div>

        <!-- Note moyenne -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Note moyenne</h3>
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="ml-1 text-sm text-gray-500">({{ $stats['total_reviews'] ?? 0 }})</span>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['rating_average'] ?? 0, 1) }}</p>
            <div class="mt-4 h-16">
                <!-- Mini graphique à insérer ici -->
            </div>
        </div>
    </div>

    <!-- Graphiques détaillés -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique de revenus -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution du chiffre d'affaires</h3>
            <div class="h-80">
                <!-- Graphique à insérer ici -->
            </div>
        </div>

        <!-- Graphique des projets -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Répartition des projets</h3>
            <div class="h-80">
                <!-- Graphique à insérer ici -->
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuration et initialisation des graphiques
    // ... code des graphiques ...
</script>
