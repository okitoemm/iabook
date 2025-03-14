<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8" x-data="calendar()">
    <!-- En-tête du calendrier -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <button @click="previousMonth()" class="p-2 hover:bg-gray-100 rounded-full">
                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <h2 x-text="currentMonthName + ' ' + currentYear" class="text-xl font-semibold text-gray-900 mx-4"></h2>
            <button @click="nextMonth()" class="p-2 hover:bg-gray-100 rounded-full">
                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        <div class="flex space-x-3">
            <button @click="today()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Aujourd'hui
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                + Nouveau RDV
            </button>
        </div>
    </div>

    <!-- Grille du calendrier -->
    <div class="bg-white shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <!-- Jours de la semaine -->
        <div class="grid grid-cols-7 gap-px border-b border-gray-200 bg-gray-50">
            <template x-for="day in ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']" :key="day">
                <div class="px-2 py-3">
                    <span x-text="day" class="text-sm font-semibold text-gray-900"></span>
                </div>
            </template>
        </div>

        <!-- Jours du mois -->
        <div class="grid grid-cols-7 gap-px">
            <template x-for="week in calendar" :key="week[0].date">
                <template x-for="day in week" :key="day.date">
                    <div :class="{
                        'bg-gray-50': !day.isCurrentMonth,
                        'bg-white': day.isCurrentMonth,
                        'bg-indigo-50': day.isSelected
                    }" class="min-h-[100px] p-2">
                        <!-- En-tête du jour -->
                        <div class="flex items-center justify-between">
                            <span x-text="day.dayNumber" 
                                  :class="{
                                      'text-gray-900': day.isCurrentMonth,
                                      'text-gray-400': !day.isCurrentMonth,
                                      'font-bold': day.isToday
                                  }" 
                                  class="text-sm"></span>
                            <template x-if="day.events && day.events.length">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-indigo-600 text-white text-xs">
                                    <span x-text="day.events.length"></span>
                                </span>
                            </template>
                        </div>

                        <!-- Liste des événements -->
                        <div class="mt-1 space-y-1">
                            <template x-for="event in day.events" :key="event.id">
                                <div :class="{
                                    'bg-blue-100 text-blue-700': event.type === 'rendez-vous',
                                    'bg-green-100 text-green-700': event.type === 'projet',
                                    'bg-red-100 text-red-700': event.type === 'urgent'
                                }" class="px-2 py-1 rounded-md text-xs truncate">
                                    <span x-text="event.time"></span>
                                    <span x-text="event.title"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('calendar', () => ({
        currentDate: new Date(),
        selectedDate: null,
        calendar: [],
        events: @json($events ?? []),

        init() {
            this.selectedDate = this.currentDate;
            this.generateCalendar();
        },

        get currentMonthName() {
            return this.currentDate.toLocaleString('fr-FR', { month: 'long' });
        },

        get currentYear() {
            return this.currentDate.getFullYear();
        },

        generateCalendar() {
            // Logique de génération du calendrier
            // À implémenter selon les besoins
        },

        previousMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1);
            this.generateCalendar();
        },

        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1);
            this.generateCalendar();
        },

        today() {
            this.currentDate = new Date();
            this.selectedDate = this.currentDate;
            this.generateCalendar();
        }
    }));
});
</script>
