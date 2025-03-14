@extends('layouts.app')

@section('title', 'Choix d\'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-indigo-50">
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Choisissez votre type d'inscription</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <!-- Option Client -->
            <a href="{{ route('register.client') }}" 
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex flex-col items-center hover:border-indigo-500 hover:ring-2 hover:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Je suis un client</h4>
                    <p class="text-sm text-gray-500">Je cherche un artisan pour mon projet</p>
                </div>
            </a>

            <!-- Option Artisan -->
            <a href="{{ route('register.artisan') }}"
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex flex-col items-center hover:border-indigo-500 hover:ring-2 hover:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Je suis un artisan</h4>
                    <p class="text-sm text-gray-500">Je propose mes services aux clients</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 