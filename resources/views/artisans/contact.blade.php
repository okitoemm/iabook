<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacter l'artisan - ArtisanPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-gray-50" x-data="{ showContactForm: false }">
    <!-- Navigation (même que welcome.blade.php) -->
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Profil de l'artisan -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative h-64">
                <img src="https://source.unsplash.com/1600x400/?workshop" alt="Cover" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                    <div class="flex items-end">
                        <img src="https://source.unsplash.com/150x150/?worker" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white">
                        <div class="ml-6 text-white">
                            <h1 class="text-3xl font-bold">Jean Dupont</h1>
                            <p class="text-xl">Plombier professionnel</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Colonne gauche -->
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h2 class="text-2xl font-bold mb-4">À propos</h2>
                            <p class="text-gray-600">
                                Plombier qualifié avec plus de 15 ans d'expérience dans le secteur. Spécialisé dans 
                                l'installation et la réparation de systèmes de plomberie résidentielle et commerciale. 
                                Intervention rapide et travail soigné garanti.
                            </p>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold mb-4">Expertise</h2>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center space-x-2">
                                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Installation sanitaire</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Dépannage urgent</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Rénovation salle de bain</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Chauffe-eau</span>
                                </div>
                            </div>
                        </div>

                        <!-- Avis clients -->
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Avis clients</h2>
                            <div class="space-y-4">
                                <div class="border-b pb-4">
                                    <div class="flex items-center mb-2">
                                        <img src="https://source.unsplash.com/50x50/?person" alt="Client" class="w-10 h-10 rounded-full">
                                        <div class="ml-4">
                                            <h4 class="font-semibold">Sophie Martin</h4>
                                            <div class="flex items-center">
                                                <div class="flex text-yellow-400">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <!-- Répéter 5 fois pour 5 étoiles -->
                                                </div>
                                                <span class="ml-2 text-gray-600">Il y a 2 semaines</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600">
                                        Excellent travail, très professionnel et ponctuel. Je recommande vivement !
                                    </p>
                                </div>
                                <!-- Autres avis... -->
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Informations pratiques</h3>
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Paris et Île-de-France
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Disponible 7j/7
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    À partir de 60€/h
                                </li>
                            </ul>
                        </div>

                        <!-- Bouton Contacter -->
                        <button @click="showContactForm = true" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Contacter l'artisan
                        </button>

                        <!-- Certifications -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Certifications</h3>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Qualibat
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    RGE
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de contact -->
        <div x-show="showContactForm" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Contacter Jean Dupont
                                </h3>
                                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Votre nom</label>
                                        <input type="text" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Votre email</label>
                                        <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description du projet</label>
                                        <textarea rows="4" name="description" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                        <div class="relative">
                                            <input type="password" name="password" id="password" required class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="togglePasswordVisibility('password')">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A6.978 6.978 0 0012 19a6.978 6.978 0 00-1.875-.175M12 4.5c-4.5 0-8.25 3.75-8.25 3.75S7.5 12 12 12s8.25-3.75 8.25-3.75S16.5 4.5 12 4.5z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation" id="password_confirmation" required class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="togglePasswordVisibility('password_confirmation')">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A6.978 6.978 0 0012 19a6.978 6.978 0 00-1.875-.175M12 4.5c-4.5 0-8.25 3.75-8.25 3.75S7.5 12 12 12s8.25-3.75 8.25-3.75S16.5 4.5 12 4.5z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Envoyer
                        </button>
                        <button @click="showContactForm = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        }
    </script>
</body>
</html> 