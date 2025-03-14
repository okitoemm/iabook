<div class="h-full flex flex-col bg-white">
    <div class="p-4 border-b">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="ml-3 text-lg font-semibold">Tableau de bord</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        @foreach([
            'overview' => ['Aperçu', 'chart-bar'],
            'projects' => ['Projets', 'briefcase'],
            'messages' => ['Messages', 'chat'],
            'calendar' => ['Calendrier', 'calendar'],
            'reviews' => ['Avis', 'star'],
            'settings' => ['Paramètres', 'cog']
        ] as $tab => $info)
            <button 
                @click="setTab('{{ $tab }}')" 
                class="w-full text-left"
            >
                <div class="nav-link" 
                     :class="{ 'bg-indigo-50 text-indigo-600': currentTab === '{{ $tab }}' }"
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($info[1] === 'chart-bar')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        @elseif($info[1] === 'briefcase')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        @elseif($info[1] === 'chat')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        @elseif($info[1] === 'calendar')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        @elseif($info[1] === 'star')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        @elseif($info[1] === 'cog')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        @endif
                    </svg>
                    <span>{{ $info[0] }}</span>
                </div>
            </button>
        @endforeach
    </nav>

    <!-- User Profile Section -->
    <div class="p-4 border-t">
        <div class="flex items-center">
            <img src="{{ auth()->user()->profile_photo_url }}" 
                 alt="{{ auth()->user()->name }}" 
                 class="h-10 w-10 rounded-full">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</div>
