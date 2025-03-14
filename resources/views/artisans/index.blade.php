@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Trouver un artisan</h1>
            <div class="flex space-x-4">
                <div class="relative">
                    <input type="text" 
                        placeholder="Rechercher un artisan..." 
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Toutes spécialités</option>
                    <option value="plomberie">Plomberie</option>
                    <option value="electricite">Électricité</option>
                    <option value="maconnerie">Maçonnerie</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($artisans as $artisan)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <img src="{{ $artisan['avatar'] }}" alt="{{ $artisan['name'] }}" 
                            class="w-16 h-16 rounded-full object-cover">
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $artisan['name'] }}</h3>
                                @if($artisan['verified'])
                                <svg class="w-5 h-5 text-blue-500 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">{{ $artisan['specialty'] }}</p>
                            <p class="text-sm text-gray-500">{{ $artisan['city'] }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= floor($artisan['rating']) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ $artisan['reviews_count'] }} avis</span>
                        </div>
                        <p class="mt-2 text-sm font-medium text-gray-900">À partir de {{ $artisan['hourly_rate'] }}/heure</p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('artisans.show', $artisan['id']) }}" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Voir le profil
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
