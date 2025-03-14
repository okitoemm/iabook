<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Mon Profil Artisan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informations personnelles -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informations personnelles</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                                    <div class="mt-1 text-gray-900">{{ auth()->user()->name }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1 text-gray-900">{{ auth()->user()->email }}</div>
                                </div>
                                <!-- Autres informations... -->
                            </div>
                        </div>

                        <!-- Informations professionnelles -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informations professionnelles</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">SIRET</label>
                                    <div class="mt-1 text-gray-900">{{ $artisan->siret ?? 'Non renseigné' }}</div>
                                </div>
                                <!-- Autres informations... -->
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('artisan.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Modifier mon profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
