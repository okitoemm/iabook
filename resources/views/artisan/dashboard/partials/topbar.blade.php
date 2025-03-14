<div class="h-16 px-4 flex items-center justify-between lg:px-8">
    <!-- Left side -->
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Page title -->
        <h1 class="text-xl font-semibold text-gray-900 lg:ml-0 ml-4" x-text="currentTab.charAt(0).toUpperCase() + currentTab.slice(1)"></h1>
    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('projects.available') }}" 
           class="btn-primary flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Nouvelles missions</span>
            @if($newProjectsCount > 0)
                <span class="bg-white text-indigo-600 px-2 py-0.5 rounded-full text-xs font-semibold">
                    {{ $newProjectsCount }}
                </span>
            @endif
        </a>

        <!-- Profile dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900">
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     alt="{{ auth()->user()->name }}"
                     class="w-8 h-8 rounded-full object-cover">
                <span class="hidden lg:block">{{ auth()->user()->name }}</span>
            </button>

            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5">
                <!-- Dropdown items -->
            </div>
        </div>
    </div>
</div>
