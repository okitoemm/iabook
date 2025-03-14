<div class="space-y-6 p-4">
    <!-- En-tête des sections -->
    <nav class="flex flex-wrap gap-2 mb-6">
        @foreach(['profile' => 'Profil Entreprise', 
                 'services' => 'Services & Tarifs',
                 'documents' => 'Documents',
                 'notifications' => 'Notifications'] as $key => $label)
            <button @click="activeSettingsTab = '{{ $key }}'"
                    :class="{'bg-indigo-100 text-indigo-700': activeSettingsTab === '{{ $key }}',
                            'bg-gray-100 text-gray-600 hover:bg-gray-200': activeSettingsTab !== '{{ $key }}'}"
                    class="px-4 py-2 rounded-lg text-sm sm:text-base transition-colors duration-200">
                {{ $label }}
            </button>
        @endforeach
    </nav>

    <!-- Profil Entreprise -->
    <div x-show="activeSettingsTab === 'profile'" class="space-y-6">
        <form action="{{ route('artisan.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Informations de base -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de base</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                            <input type="text" name="business_name" 
                                   value="{{ old('business_name', $artisan->business_name ?? '') }}"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">SIRET</label>
                            <input type="text" name="siret" 
                                   value="{{ old('siret', $artisan->siret ?? '') }}"
                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Description de l'activité</label>
                    <textarea name="description" rows="4"
                              class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $artisan->description ?? '') }}</textarea>
                </div>
            </div>
        </form>
    </div>

    <!-- Services & Tarifs -->
    <div x-show="activeSettingsTab === 'services'" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Liste des services -->
            <div class="bg-white p-6 rounded-lg shadow-sm col-span-1 md:col-span-2 lg:col-span-3">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="p-4">Service</th>
                                <th class="p-4">Tarif</th>
                                <th class="p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($services ?? [] as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4">{{ $service->name }}</td>
                                    <td class="p-4">{{ $service->price }}€</td>
                                    <td class="p-4">
                                        <button class="text-indigo-600 hover:text-indigo-900">Modifier</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <div x-show="activeSettingsTab === 'documents'" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Zone de dépôt -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" class="hidden" id="file-upload" multiple>
                    <label for="file-upload" class="cursor-pointer">
                        <span class="mt-2 block text-sm text-gray-600">
                            Glissez-déposez vos fichiers ici ou
                            <span class="text-indigo-600 hover:text-indigo-500">parcourez</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Liste des documents -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                        @foreach(range(1, 5) as $doc)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Document {{ $doc }}</div>
                                    <div class="text-sm text-gray-500">PDF • 2.3 MB</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div x-show="activeSettingsTab === 'notifications'" class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="space-y-4">
                @foreach([
                    'new_projects' => 'Nouveaux projets correspondant à mes critères',
                    'messages' => 'Nouveaux messages',
                    'reviews' => 'Nouveaux avis clients',
                    'reminders' => 'Rappels de projets',
                    'updates' => 'Mises à jour importantes'
                ] as $key => $label)
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm sm:text-base font-medium text-gray-700">{{ $label }}</p>
                            <p class="text-xs sm:text-sm text-gray-500">Email et notifications push</p>
                        </div>
                        <div class="ml-4">
                            <button type="button" 
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
                                    :class="{'bg-indigo-600': {{ $key }}, 'bg-gray-200': !{{ $key }}}"
                                    @click="{{ $key }} = !{{ $key }}">
                                <span class="translate-x-0 pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                      :class="{'translate-x-5': {{ $key }}, 'translate-x-0': !{{ $key }}}">
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsData', () => ({
        activeSettingsTab: 'profile',
        new_projects: true,
        messages: true,
        reviews: true,
        reminders: false,
        updates: true
    }))
})
</script>
