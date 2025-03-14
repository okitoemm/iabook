<div class="h-full flex flex-col bg-indigo-700">
    <nav class="mt-5 flex-1 px-2 space-y-1">
        @foreach([
            'overview' => ['Tableau de bord', 'home'],
            'projects' => ['Projets', 'briefcase'],
            'messages' => ['Messages', 'chat'],
            'calendar' => ['Calendrier', 'calendar'],
            'reviews' => ['Avis', 'star'],
            'analytics' => ['Statistiques', 'chart-bar'],
            'settings' => ['Paramètres', 'cog']
        ] as $tab => $info)
            <a href="#{{ $tab }}"
               @click="currentTab = '{{ $tab }}'"
               :class="{'bg-indigo-800 text-white': currentTab === '{{ $tab }}', 'text-indigo-100 hover:bg-indigo-600': currentTab !== '{{ $tab }}'}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-150">
                <x-heroicon-o-{{ $info[1] }} class="mr-3 flex-shrink-0 h-6 w-6"/>
                {{ $info[0] }}
            </a>
        @endforeach
    </nav>

    <!-- Statut Pro -->
    <div class="p-4 bg-indigo-800">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">Statut Pro</p>
                <p class="text-xs text-indigo-200">Vérifié depuis {{ auth()->user()->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>
