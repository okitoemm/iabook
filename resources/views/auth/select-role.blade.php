<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-indigo-50">
        <div class="max-w-2xl w-full mx-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Bienvenue sur ArtisanPro</h2>
                <p class="text-gray-600">Dites-nous qui vous êtes pour commencer</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Client Card -->
                <button onclick="selectRole('client')" 
                    class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-indigo-500">
                    <div class="absolute top-4 right-4">
                        <svg class="w-6 h-6 text-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Je suis un Client</h3>
                        <p class="text-gray-600">Je cherche un artisan qualifié pour réaliser mes travaux</p>
                        
                        <ul class="mt-4 space-y-2 text-left text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Publiez vos projets gratuitement
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Recevez des devis d'artisans qualifiés
                            </li>
                        </ul>
                    </div>
                </button>

                <!-- Artisan Card -->
                <button onclick="selectRole('artisan')"
                    class="group relative bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-indigo-500">
                    <div class="absolute top-4 right-4">
                        <svg class="w-6 h-6 text-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Je suis un Artisan</h3>
                        <p class="text-gray-600">Je propose mes services aux clients</p>
                        
                        <ul class="mt-4 space-y-2 text-left text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Accédez à des projets qualifiés
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Développez votre activité
                            </li>
                        </ul>
                    </div>
                </button>
            </div>

            <form id="roleForm" method="POST" action="{{ route('role.store') }}" class="hidden">
                @csrf
                <input type="hidden" name="role" id="selectedRole">
            </form>
        </div>
    </div>

    <script>
    function selectRole(role) {
        document.getElementById('selectedRole').value = role;
        document.getElementById('roleForm').submit();
    }
    </script>
</x-app-layout>
