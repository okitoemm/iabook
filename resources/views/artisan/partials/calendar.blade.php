<div x-data="calendar()" class="bg-white rounded-lg shadow">
    <div class="p-4">
        <!-- En-tête du calendrier -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex space-x-4">
                <button @click="previousMonth()" class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h2 x-text="monthYear" class="text-lg font-semibold text-gray-900"></h2>
                <button @click="nextMonth()" class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200">
                    Aujourd'hui
                </button>
                <button class="px-3 py-1 text-sm border border-gray-300 rounded-full hover:bg-gray-50">
                    Vue Semaine
                </button>
            </div>
        </div>

        <!-- Jours de la semaine -->
        <div class="grid grid-cols-7 gap-1 mb-2">
            <template x-for="day in ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']">
                <div class="text-center text-sm font-medium text-gray-500" x-text="day"></div>
            </template>
        </div>

        <!-- Grille des jours -->
        <div class="grid grid-cols-7 gap-1">
            <template x-for="day in days" :key="day.date">
                <div 
                    @click="selectDate(day)"
                    :class="{
                        'bg-indigo-50': isSelected(day),
                        'bg-gray-50': !isCurrentMonth(day),
                        'cursor-pointer hover:bg-gray-50': isCurrentMonth(day)
                    }"
                    class="aspect-square p-2 rounded-lg"
                >
                    <div class="relative h-full">
                        <!-- Numéro du jour -->
                        <div 
                            :class="{
                                'text-gray-900': isCurrentMonth(day),
                                'text-gray-400': !isCurrentMonth(day),
                                'font-bold': isToday(day)
                            }"
                            class="text-sm"
                            x-text="day.dayOfMonth"
                        ></div>

                        <!-- Indicateurs d'événements -->
                        <div class="absolute bottom-0 left-0 right-0">
                            <template x-if="hasEvents(day)">
                                <div class="flex justify-center space-x-1">
                                    <template x-for="event in getEvents(day)" :key="event.id">
                                        <div
                                            :class="{
                                                'bg-blue-400': event.type === 'rendez-vous',
                                                'bg-green-400': event.type === 'projet',
                                                'bg-yellow-400': event.type === 'urgent'
                                            }"
                                            class="w-1.5 h-1.5 rounded-full"
                                            :title="event.title"
                                        ></div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Liste des événements du jour sélectionné -->
    <div class="border-t border-gray-200 p-4">
        <h3 class="text-sm font-medium text-gray-900 mb-3" x-text="selectedDateEvents.length + ' événements aujourd\'hui'"></h3>
        <div class="space-y-3">
            <template x-for="event in selectedDateEvents" :key="event.id">
                <div class="flex items-center space-x-3 text-sm">
                    <div
                        :class="{
                            'bg-blue-100 text-blue-800': event.type === 'rendez-vous',
                            'bg-green-100 text-green-800': event.type === 'projet',
                            'bg-yellow-100 text-yellow-800': event.type === 'urgent'
                        }"
                        class="px-2 py-1 rounded-full text-xs"
                        x-text="event.type"
                    ></div>
                    <span x-text="event.time"></span>
                    <span x-text="event.title"></span>
                </div>
            </template>
        </div>
    </div>
</div>

<!-- Script Alpine.js pour la logique du calendrier -->
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('calendar', () => ({
        currentDate: new Date(),
        selectedDate: new Date(),
        days: [],
        events: @json($events ?? []),

        init() {
            this.generateDays();
        },

        generateDays() {
            // Logique de génération des jours du mois
            // ... (à implémenter)
        },

        get monthYear() {
            return this.currentDate.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
        },

        get selectedDateEvents() {
            // Retourne les événements du jour sélectionné
            return this.events.filter(event => {
                const eventDate = new Date(event.date);
                return eventDate.toDateString() === this.selectedDate.toDateString();
            });
        },

        previousMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1);
            this.generateDays();
        },

        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1);
            this.generateDays();
        },

        isToday(day) {
            const today = new Date();
            return day.date.toDateString() === today.toDateString();
        },

        isSelected(day) {
            return day.date.toDateString() === this.selectedDate.toDateString();
        },

        selectDate(day) {
            this.selectedDate = day.date;
        },

        hasEvents(day) {
            return this.getEvents(day).length > 0;
        },

        getEvents(day) {
            return this.events.filter(event => {
                const eventDate = new Date(event.date);
                return eventDate.toDateString() === day.date.toDateString();
            });
        }
    }));
});
</script>
