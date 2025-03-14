@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <p class="text-gray-600">{{ auth()->user()->city }}</p>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('profile.edit') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Modifier le profil
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('projects.create') }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Nouveau Projet</h3>
                    <p class="text-sm text-gray-600">Créer une nouvelle demande</p>
                </div>
            </a>
            <a href="{{ route('messages.index') }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Messages</h3>
                    <p class="text-sm text-gray-600">Voir vos conversations</p>
                </div>
            </a>
        </div>

        <!-- Recent Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Projets Récents</h2>
            @forelse(auth()->user()->projects()->latest()->take(5)->get() as $project)
                <div class="border-b last:border-0 py-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($project->description, 100) }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">Voir détails →</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Aucun projet pour le moment.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
