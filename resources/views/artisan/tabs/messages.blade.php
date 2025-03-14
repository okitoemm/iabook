<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8" x-data="{ selectedConversation: null }">
    <div class="flex h-[calc(100vh-200px)]">
        <!-- Liste des conversations -->
        <div class="w-1/3 border-r border-gray-200 overflow-y-auto">
            <div class="p-4 border-b border-gray-200">
                <div class="relative">
                    <input type="text" placeholder="Rechercher une conversation..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($conversations ?? [] as $conversation)
                    <button 
                        @click="selectedConversation = {{ $conversation->id }}"
                        class="w-full px-4 py-3 flex items-center hover:bg-gray-50"
                        :class="{ 'bg-indigo-50': selectedConversation === {{ $conversation->id }} }">
                        <img class="h-10 w-10 rounded-full" src="{{ $conversation->other_user->profile_photo_url }}" alt="">
                        <div class="ml-3 flex-1 text-left">
                            <p class="text-sm font-medium text-gray-900">{{ $conversation->other_user->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $conversation->last_message->content }}</p>
                        </div>
                        <div class="ml-2 flex flex-col items-end">
                            <span class="text-xs text-gray-500">{{ $conversation->last_message->created_at->format('H:i') }}</span>
                            @if($conversation->unread_count)
                                <span class="bg-indigo-600 text-white text-xs rounded-full px-2 py-0.5 mt-1">
                                    {{ $conversation->unread_count }}
                                </span>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        Aucune conversation
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Zone de conversation -->
        <div class="flex-1 flex flex-col">
            <template x-if="selectedConversation">
                <div class="flex-1 flex flex-col">
                    <!-- En-tête conversation -->
                    <div class="p-4 border-b border-gray-200 flex items-center">
                        <img class="h-10 w-10 rounded-full" src="" alt="" x-bind:src="conversation.user.profile_photo_url">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900" x-text="conversation.user.name"></h3>
                            <p class="text-xs text-gray-500" x-text="conversation.project ? `Projet: ${conversation.project.title}` : ''"></p>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <template x-for="message in conversation.messages" :key="message.id">
                            <div :class="{'flex justify-end': message.is_mine}">
                                <div :class="{
                                    'bg-indigo-600 text-white': message.is_mine,
                                    'bg-gray-100 text-gray-900': !message.is_mine
                                }" class="max-w-xs rounded-lg px-4 py-2 mb-2">
                                    <p x-text="message.content"></p>
                                    <span class="text-xs opacity-75" x-text="message.time"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Zone de saisie -->
                    <div class="p-4 border-t border-gray-200">
                        <form class="flex space-x-2">
                            <input type="text" placeholder="Votre message..." class="flex-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Envoyer
                            </button>
                        </form>
                    </div>
                </div>
            </template>

            <template x-if="!selectedConversation">
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Sélectionnez une conversation</h3>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
