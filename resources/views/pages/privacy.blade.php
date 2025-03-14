@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Politique de confidentialité</h1>
        
        <div class="prose max-w-none">
            <h2 class="text-xl font-semibold mb-4">1. Collecte des données</h2>
            <p class="mb-4">
                Nous collectons uniquement les données nécessaires au bon fonctionnement de nos services.
            </p>

            <h2 class="text-xl font-semibold mb-4">2. Utilisation des données</h2>
            <p class="mb-4">
                Vos données personnelles sont utilisées uniquement dans le cadre de nos services et ne sont jamais partagées avec des tiers sans votre consentement.
            </p>

            <h2 class="text-xl font-semibold mb-4">3. Protection des données</h2>
            <p class="mb-4">
                Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos données personnelles.
            </p>

            <!-- Ajoutez d'autres sections selon vos besoins -->
        </div>
    </div>
</div>
@endsection
