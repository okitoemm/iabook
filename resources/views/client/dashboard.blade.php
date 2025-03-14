@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6" x-data="clientDashboard()">
    <!-- En-tête du profil -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="relative h-32 bg-gradient-to-r from-indigo-500 to-purple-600">
                <button @click="$refs.coverInput.click()" class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
                <input type="file" x-ref="coverInput" class="hidden" @change="updateCoverPhoto">
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:items-center">
                        <div class="relative -mt-16">
                            <div class="relative">
                                <img :src="profile.avatar || 'https://ui-avatars.com/api/?name={{ $user->name }}'" 
                                    class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover"
                                    alt="{{ $user->name }}">
                                <button @click="$refs.avatarInput.click()" 
                                    class="absolute bottom-0 right-0 bg-indigo-600 p-2 rounded-full text-white hover:bg-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <input type="file" x-ref="avatarInput" class="hidden" @change="updateAvatar">
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <div class="mt-1 flex items-center text-sm text-gray-600">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $user->city }} ({{ $user->postal_code }})
                            </div>
                            <div class="mt-1 flex items-center text-sm text-gray-600">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 flex space-x-3">
                        <a href="{{ route('profile.edit') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier le profil
                        </a>
                        <a href="{{ route('settings.show') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Paramètres
                        </a>
                        <a href="{{ route('projects.create') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nouveau Projet
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="border-t border-gray-200 bg-gray-50 grid grid-cols-3 divide-x divide-gray-200">
                <div class="px-4 py-3 sm:px-6 text-center">
                    <div class="text-2xl font-semibold text-indigo-600">{{ $user->projects()->count() }}</div>
                    <div class="text-sm text-gray-500">Projets Totaux</div>
                </div>
                <div class="px-4 py-3 sm:px-6 text-center">
                    <div class="text-2xl font-semibold text-indigo-600">{{ $user->projects()->where('status', 'completed')->count() }}</div>
                    <div class="text-sm text-gray-500">Projets Terminés</div>
                </div>
                <div class="px-4 py-3 sm:px-6 text-center">
                    <div class="text-2xl font-semibold text-indigo-600">{{ $user->projects()->where('status', 'pending')->count() }}</div>
                    <div class="text-sm text-gray-500">En Attente</div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('messages.index') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Messages</h3>
                            <p class="text-sm text-gray-500">Voir vos conversations</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('projects.create') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Créer une demande</h3>
                            <p class="text-sm text-gray-500">Publier un nouveau projet</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('artisans.index') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Trouver un artisan</h3>
                            <p class="text-sm text-gray-500">Parcourir les profils</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Liste des projets récents -->
        <div class="mt-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Projets Récents</h2>
                <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Voir tous les projets →
                </a>
            </div>
            
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($projects as $project)
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $project->title }}</h3>
                                <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $project->description }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        
                        @if($project->photos && is_array($project->photos) && count($project->photos) > 0)
                            <div class="mt-4">
                                <img src="{{ $project->photos[0] }}" 
                                     alt="Project thumbnail" 
                                     class="h-32 w-full object-cover rounded-md">
                            </div>
                        @endif

                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $project->created_at->format('d M Y') }}
                            </div>
                            <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Voir détails →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function clientDashboard() {
    return {
        profile: {
            avatar: '{{ $user->avatar }}',
            cover: '{{ $user->cover_photo }}'
        },
        
        updateAvatar(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('avatar', file);
            
            fetch('/profile/avatar', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.profile.avatar = data.url;
                }
            });
        },
        
        updateCoverPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('cover', file);
            
            fetch('/profile/cover', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.profile.cover = data.url;
                }
            });
        }
    }
}
</script>
@endpush

@endsection
