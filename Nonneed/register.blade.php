@extends('layouts.app')

@section('title', request()->type === 'artisan' ? 'Inscription Artisan' : 'Inscription Client')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-indigo-50 via-white to-indigo-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec animation -->
        <div class="text-center mb-10 transform hover:scale-105 transition-transform duration-300">
            <h1 class="text-4xl font-extrabold text-indigo-600 mb-2">
                {{ request()->type === 'artisan' ? 'Rejoignez notre communauté d\'artisans' : 'Créez votre compte client' }}
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                {{ request()->type === 'artisan' 
                    ? 'Développez votre activité en rejoignant notre plateforme de mise en relation avec des clients qualifiés.'
                    : 'Trouvez les meilleurs artisans pour vos projets et gérez vos demandes en toute simplicité.' 
                }}
            </p>
        </div>

        <!-- Carte d'inscription avec animation -->
        <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:shadow-xl transition-all duration-300">
            <!-- Indicateur de progression -->
            <div class="mb-8">
                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-100">
                        <div id="progress-bar" style="width:0%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500"></div>
                    </div>
                    <div class="flex justify-between text-xs text-indigo-600">
                        <span>Informations de base</span>
                        <span>{{ request()->type === 'artisan' ? 'Informations professionnelles' : 'Préférences' }}</span>
                        <span>Validation</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ request()->type === 'artisan' ? route('register.artisan') : route('register.client') }}" 
                  class="space-y-6" enctype="multipart/form-data" id="registration-form">
                @csrf

                <!-- Étape 1: Informations de base -->
                <div class="step" data-step="1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="name" 
                                    id="name"
                                    required 
                                    placeholder="John Doe"
                                    autocomplete="name"
                                    class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input type="email" 
                                    name="email" 
                                    id="email"
                                    required 
                                    placeholder="john@exempple.com"
                                    autocomplete="email"
                                    class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" 
                                    name="password" 
                                    id="password"
                                    required 
                                    placeholder="Minimum 8 caractères"
                                    autocomplete="new-password"
                                    class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation" required class="pl-10 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Informations spécifiques -->
                <div class="step hidden" data-step="2">
                    @if(request()->type === 'artisan')
                        <!-- Champs spécifiques aux artisans -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise</label>
                                <input type="text" name="business_name" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">SIRET</label>
                                <input type="text" name="siret" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité</label>
                                <select name="specialty" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionnez votre spécialité</option>
                                    <option value="plomberie">Plomberie</option>
                                    <option value="electricite">Électricité</option>
                                    <option value="menuiserie">Menuiserie</option>
                                    <!-- Autres options... -->
                                </select>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Années d'expérience</label>
                                <input type="number" name="experience_years" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description de votre activité</label>
                                <textarea name="description" rows="4" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                        </div>
                    @else
                        <!-- Champs spécifiques aux clients -->
                        <div class="grid grid-cols-1 gap-6">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                                <input type="text" name="location" class="block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Types de projets qui vous intéressent</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" name="interests[]" value="renovation" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="text-gray-700">Rénovation</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" name="interests[]" value="construction" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="text-gray-700">Construction</span>
                                    </label>
                                    <!-- Autres options... -->
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Étape 3: Validation -->
                <div class="step hidden" data-step="3">
                    <div class="space-y-6">
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-indigo-900 mb-2">Dernière étape !</h3>
                            <p class="text-indigo-700">Vérifiez vos informations avant de finaliser votre inscription.</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-900">
                                J'accepte les <a href="#" class="text-indigo-600 hover:text-indigo-500">conditions d'utilisation</a>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Navigation des étapes -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="prev-step" class="hidden px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Précédent
                    </button>
                    <button type="button" id="next-step" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Suivant
                    </button>
                    <button type="submit" id="submit-form" class="hidden px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>

        <!-- Lien de connexion -->
        <p class="mt-8 text-center text-sm text-gray-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Connectez-vous
            </a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    const form = document.getElementById('registration-form');
    const nextBtn = document.getElementById('next-step');
    const prevBtn = document.getElementById('prev-step');
    const submitBtn = document.getElementById('submit-form');
    const progressBar = document.getElementById('progress-bar');

    function updateStep(step) {
        // Mise à jour de la barre de progression
        progressBar.style.width = ((step - 1) / (totalSteps - 1) * 100) + '%';

        // Afficher/masquer les étapes
        document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
        document.querySelector(`.step[data-step="${step}"]`).classList.remove('hidden');

        // Mise à jour des boutons
        prevBtn.classList.toggle('hidden', step === 1);
        nextBtn.classList.toggle('hidden', step === totalSteps);
        submitBtn.classList.toggle('hidden', step !== totalSteps);

        // Animation de transition
        const currentStep = document.querySelector(`.step[data-step="${step}"]`);
        currentStep.classList.add('animate-fade-in');
        setTimeout(() => currentStep.classList.remove('animate-fade-in'), 500);
    }

    nextBtn.addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStep(currentStep);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateStep(currentStep);
        }
    });

    // Animation du formulaire lors de la soumission
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Création en cours...
        `;
    });
});
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush 