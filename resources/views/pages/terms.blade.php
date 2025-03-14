@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm px-8 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Conditions Générales d'Utilisation</h1>
        
        <div class="prose prose-indigo max-w-none">
            <h2>1. Acceptation des conditions</h2>
            <p>En accédant et en utilisant ce site, vous acceptez d'être lié par ces conditions d'utilisation...</p>

            <h2>2. Description du service</h2>
            <p>Notre plateforme met en relation des artisans qualifiés avec des clients...</p>

            <h2>3. Inscription et compte</h2>
            <p>Pour utiliser nos services, vous devez créer un compte et fournir des informations exactes...</p>

            <h2>4. Responsabilités des utilisateurs</h2>
            <p>Les utilisateurs s'engagent à :</p>
            <ul>
                <li>Fournir des informations exactes et à jour</li>
                <li>Respecter la législation en vigueur</li>
                <li>Ne pas usurper l'identité d'un tiers</li>
                <li>Maintenir la confidentialité de leurs identifiants</li>
            </ul>

            <h2>5. Protection des données</h2>
            <p>Nous nous engageons à protéger vos données personnelles conformément au RGPD...</p>

            <h2>6. Propriété intellectuelle</h2>
            <p>Tout le contenu présent sur le site est protégé par le droit d'auteur...</p>

            <h2>7. Limitation de responsabilité</h2>
            <p>Notre responsabilité ne saurait être engagée en cas de :</p>
            <ul>
                <li>Indisponibilité temporaire du service</li>
                <li>Perte de données</li>
                <li>Dommages indirects</li>
            </ul>

            <h2>8. Modification des conditions</h2>
            <p>Nous nous réservons le droit de modifier ces conditions à tout moment...</p>

            <h2>9. Contact</h2>
            <p>Pour toute question concernant ces conditions, contactez-nous à...</p>
        </div>

        <div class="mt-8 text-sm text-gray-500">
            <p>Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection
