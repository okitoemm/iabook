@extends('layouts.app')

@section('content')
<div x-data="chatSystem()" 
    class="h-screen bg-gray-100 overflow-hidden flex flex-col"
    x-init="initChat">
    <!-- Mobile Header -->
    <header class="bg-white shadow-sm border-b lg:hidden">
        <div class="px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-semibold" x-text="selectedChat ? 'Retour' : 'Messages'"></h1>
            <button x-show="selectedChat" @click="selectedChat = null" class="text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>
    </header>

    <!-- Chat Container -->
    <div class="flex-1 overflow-hidden">
        <div class="h-full flex">
            <!-- Conversation List - Hidden on mobile when chat is selected -->
            <div class="w-full lg:w-1/3 bg-white border-r" 
                x-show="!selectedChat || window.innerWidth >= 1024">
                <!-- Search Bar -->
                <div class="p-3 border-b">
                    <div class="relative">
                        <input type="text" 
                            x-model="searchQuery"
                            placeholder="Rechercher une conversation..." 
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Conversations List -->
                <div class="overflow-y-auto h-[calc(100vh-130px)]">
                    <template x-for="chat in filteredChats" :key="chat.id">
                        <div @click="openChat(chat)" 
                            class="p-3 border-b hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                            :class="{ 'bg-gray-50': selectedChat?.id === chat.id }">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img :src="chat.avatar" :alt="chat.name" 
                                        class="w-12 h-12 rounded-full object-cover">
                                    <div x-show="chat.online" 
                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold truncate" x-text="chat.name"></h3>
                                        <span class="text-xs text-gray-500" x-text="chat.lastMessageTime"></span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate" x-text="chat.lastMessage"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Chat Area - Full width on mobile when selected -->
            <div class="w-full lg:w-2/3 bg-white flex flex-col"
                x-show="selectedChat || window.innerWidth >= 1024">
                <template x-if="selectedChat">
                    <div class="flex-1 flex flex-col h-full">
                        <!-- Chat Header -->
                        <div class="p-3 border-b flex items-center space-x-4">
                            <div class="relative">
                                <img :src="selectedChat.avatar" :alt="selectedChat.name" 
                                    class="w-10 h-10 rounded-full object-cover">
                                <div x-show="selectedChat.online" 
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold" x-text="selectedChat.name"></h3>
                                <p class="text-sm text-gray-600" x-text="selectedChat.online ? 'En ligne' : 'Hors ligne'"></p>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div class="flex-1 overflow-y-auto p-4 space-y-4" 
                            x-ref="messagesContainer"
                            @scroll="handleScroll">
                            <template x-for="message in selectedChat.messages" :key="message.id">
                                <div :class="message.sent ? 'flex justify-end' : 'flex justify-start'">
                                    <div :class="{
                                        'bg-indigo-600 text-white': message.sent,
                                        'bg-gray-100 text-gray-800': !message.sent
                                    }" class="rounded-lg p-3 max-w-[80%] lg:max-w-md break-words">
                                        <p class="whitespace-pre-wrap" x-text="message.text"></p>
                                        <div class="flex items-center justify-end mt-1 space-x-1">
                                            <span class="text-xs" 
                                                :class="message.sent ? 'text-indigo-200' : 'text-gray-500'"
                                                x-text="message.time">
                                            </span>
                                            <template x-if="message.sent">
                                                <svg class="w-4 h-4" :class="message.read ? 'text-blue-400' : 'text-indigo-200'" 
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Message Input -->
                        <div class="p-3 border-t">
                            <div class="flex items-center space-x-2">
                                <!-- Emoji Picker -->
                                <div class="relative">
                                    <button @click="toggleEmojiPicker" 
                                        class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                    <div x-show="showEmojiPicker" 
                                        @click.away="showEmojiPicker = false"
                                        class="absolute bottom-12 left-0 bg-white border rounded-lg shadow-lg p-2 w-64 h-48 overflow-y-auto grid grid-cols-8 gap-1">
                                        <template x-for="emoji in emojis" :key="emoji">
                                            <button @click="addEmoji(emoji)" 
                                                class="p-1 hover:bg-gray-100 rounded"
                                                x-text="emoji">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                
                                <!-- Message Input -->
                                <div class="flex-1">
                                    <textarea 
                                        x-model="newMessage" 
                                        @keydown.enter.prevent="sendMessage"
                                        placeholder="Écrivez votre message..." 
                                        rows="1"
                                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 resize-none"
                                        x-ref="messageInput"
                                        @input="autoGrow($event.target)">
                                    </textarea>
                                </div>

                                <!-- Send Button -->
                                <button @click="sendMessage" 
                                    class="bg-indigo-600 text-white p-2 rounded-lg hover:bg-indigo-700 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="!selectedChat">
                    <div class="flex-1 flex items-center justify-center text-gray-500">
                        Sélectionnez une conversation pour commencer
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function chatSystem() {
    return {
        selectedChat: null,
        showEmojiPicker: false,
        newMessage: '',
        searchQuery: '',
        chats: [
            {
                id: 1,
                name: 'Jean Dupont',
                avatar: 'https://source.unsplash.com/50x50/?portrait,man',
                online: true,
                lastMessage: 'Bonjour, je suis intéressé par votre service...',
                lastMessageTime: '10:30',
                messages: [
                    {
                        id: 1,
                        text: 'Bonjour, je suis intéressé par votre service de plomberie.',
                        time: '10:30',
                        sent: false,
                        read: true
                    },
                    {
                        id: 2,
                        text: 'Bonjour ! Je vous remercie de votre intérêt. Comment puis-je vous aider ?',
                        time: '10:31',
                        sent: true,
                        read: true
                    }
                ]
            },
            // Ajoutez d'autres conversations...
        ],
        emojis: ['😀', '😃', '😄', '😁', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘'],
        
        get filteredChats() {
            return this.chats.filter(chat => 
                chat.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                chat.lastMessage.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },

        initChat() {
            this.scrollToBottom();
            this.handleResize();
            window.addEventListener('resize', this.handleResize);
        },

        handleResize() {
            if (window.innerWidth >= 1024) {
                this.selectedChat = null;
            }
        },

        openChat(chat) {
            this.selectedChat = chat;
            this.$nextTick(() => {
                this.scrollToBottom();
                if (this.$refs.messageInput) {
                    this.$refs.messageInput.focus();
                }
            });
        },

        scrollToBottom() {
            if (this.$refs.messagesContainer) {
                this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
            }
        },

        toggleEmojiPicker() {
            this.showEmojiPicker = !this.showEmojiPicker;
        },

        addEmoji(emoji) {
            this.newMessage += emoji;
            this.showEmojiPicker = false;
            this.$refs.messageInput.focus();
        },

        autoGrow(element) {
            element.style.height = '5px';
            element.style.height = (element.scrollHeight) + 'px';
        },

        sendMessage() {
            if (!this.newMessage.trim()) return;
            
            const message = {
                id: Date.now(),
                text: this.newMessage.trim(),
                time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }),
                sent: true,
                read: false
            };

            this.selectedChat.messages.push(message);
            this.selectedChat.lastMessage = message.text;
            this.selectedChat.lastMessageTime = message.time;
            this.newMessage = '';

            this.$nextTick(() => {
                this.scrollToBottom();
                this.$refs.messageInput.style.height = 'auto';
            });
        },

        handleScroll(e) {
            // Implement infinite scroll for loading more messages
            if (e.target.scrollTop === 0) {
                // Load more messages
                console.log('Loading more messages...');
            }
        }
    }
}
</script>
@endpush

@endsection