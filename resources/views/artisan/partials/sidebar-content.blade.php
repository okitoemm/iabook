<div class="flex flex-col h-full">
    <!-- Logo et nom -->
    <div class="flex items-center h-16 px-4 bg-indigo-800">
        <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
        <span class="ml-2 text-xl font-bold text-white">ArtisanPro</span>
    </div>

    <!-- Menu principal -->
    <nav class="mt-5 px-2">
        <a href="#overview" 
           @click="currentTab = 'overview'" 
           :class="{'bg-indigo-800': currentTab === 'overview'}"
           class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-white hover:bg-indigo-800">
            Vue d'ensemble
        </a>
        <a href="#opportunities" 
           @click.prevent="currentTab = 'opportunities'" 
           :class="{'bg-indigo-800 text-white': currentTab === 'opportunities'}"
           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-indigo-600 text-indigo-100">
            <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Opportunités
            <span class="ml-auto inline-block py-0.5 px-2 text-xs rounded-full bg-indigo-800">
                {{ $newOpportunities ?? 0 }}
            </span>
        </a>

        <!-- Autres éléments du menu -->
        @foreach([
            'projects' => ['Mes Projets', 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'],
            'messages' => ['Messages', 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
            'calendar' => ['Calendrier', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            'reviews' => ['Avis Clients', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
            'analytics' => ['Statistiques', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            'settings' => ['Paramètres', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z']
        ] as $tab => [$label, $path])
            <a href="#{{ $tab }}" 
               @click.prevent="currentTab = '{{ $tab }}'" 
               :class="{'bg-indigo-800 text-white': currentTab === '{{ $tab }}'}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-indigo-600 text-indigo-100">
                <svg class="mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                </svg>
                {{ $label }}
            </a>
        @endforeach
    </nav>

    <!-- Profil utilisateur -->
    <div class="flex items-center p-4 bg-indigo-800">
        <img class="h-10 w-10 rounded-full" 
             src="{{ auth()->user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" 
             alt="{{ auth()->user()->name }}">
        <div class="ml-3">
            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
            <p class="text-xs text-indigo-200">{{ auth()->user()->email }}</p>
        </div>
    </div>
</div>
