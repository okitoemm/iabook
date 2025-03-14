<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="bg-white shadow sm:rounded-lg">
        <!-- Navigation des paramètres -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button 
                    @click="settingsTab = 'profile'" 
                    :class="{'border-indigo-500 text-indigo-600': settingsTab === 'profile'}"
                    class="border-transparent text-gray-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Profil Entreprise
                </button>
                
                <button 
                    @click="settingsTab = 'services'" 
                    :class="{'border-indigo-500 text-indigo-600': settingsTab === 'services'}"
                    class="border-transparent text-gray-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Services & Tarifs
                </button>

                <button 
                    @click="settingsTab = 'documents'" 
                    :class="{'border-indigo-500 text-indigo-600': settingsTab === 'documents'}"
                    class="border-transparent text-gray-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Documents & Certifications
                </button>

                <button 
                    @click="settingsTab = 'notifications'" 
                    :class="{'border-indigo-500 text-indigo-600': settingsTab === 'notifications'}"
                    class="border-transparent text-gray-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Notifications
                </button>
            </nav>
        </div>

        <!-- Contenu des paramètres -->
        <div class="p-6">
            <!-- Profil Entreprise -->
            <div x-show="settingsTab === 'profile'" class="space-y-6">
                <form action="{{ route('artisan.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="business_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                            <input type="text" name="business_name" id="business_name" 
                                   value="{{ old('business_name', $artisan?->business_name ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="siret" class="block text-sm font-medium text-gray-700">Numéro SIRET</label>
                            <input type="text" name="siret" id="siret" 
                                   value="{{ old('siret', $artisan?->siret ?? '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description de l'activité</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $artisan?->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Services & Tarifs -->
            <div x-show="settingsTab === 'services'" class="space-y-6">
                <!-- Liste des services -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($services ?? [] as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->price }}€/h</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900">Modifier</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Documents & Certifications -->
            <div x-show="settingsTab === 'documents'" class="space-y-6">
                <!-- Zone de dépôt de documents -->
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Télécharger un fichier</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">ou glisser-déposer</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF jusqu'à 10MB</p>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div x-show="settingsTab === 'notifications'" class="space-y-6">
                <div class="space-y-4">
                    @foreach([
                        'new_projects' => 'Nouveaux projets correspondant à mes critères',
                        'messages' => 'Nouveaux messages',
                        'reviews' => 'Nouveaux avis clients',
                        'reminders' => 'Rappels de projets',
                        'updates' => 'Mises à jour importantes'
                    ] as $key => $label)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $label }}</p>
                            </div>
                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="true">
                                <span class="sr-only">{{ $label }}</span>
                                <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settings', () => ({
        settingsTab: 'profile'
    }))
})
</script>
