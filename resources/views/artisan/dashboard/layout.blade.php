<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Artisan Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Responsive Grid System */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
            padding: 1rem;
        }

        @media (min-width: 640px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
                padding: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: repeat(3, 1fr);
                padding: 2rem;
            }
        }

        @media (min-width: 1536px) {
            .dashboard-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Card Components */
        .dashboard-card {
            @apply bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Responsive Typography */
        .text-responsive {
            @apply text-sm sm:text-base lg:text-lg;
        }

        /* Responsive Navigation */
        .nav-link {
            @apply flex items-center px-3 py-2 sm:px-4 sm:py-3 text-gray-600 rounded-lg 
                   hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200
                   text-sm sm:text-base;
        }

        /* Responsive Container */
        .content-container {
            @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8;
            min-height: calc(100vh - 4rem);
        }

        /* Responsive Tables */
        .responsive-table {
            @apply w-full;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Responsive Form Elements */
        .form-input {
            @apply w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500
                   text-sm sm:text-base;
        }

        /* Responsive Buttons */
        .btn {
            @apply inline-flex items-center justify-center px-4 py-2 rounded-lg
                   transition-colors duration-200 text-sm sm:text-base
                   whitespace-nowrap;
        }

        .btn-primary {
            @apply bg-indigo-600 text-white hover:bg-indigo-700;
        }
    </style>
</head>

<body class="h-full bg-gray-50" x-data="dashboardState">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-40 lg:hidden"
             @click="sidebarOpen = false">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
        </div>

        <nav :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
             class="fixed inset-y-0 left-0 flex flex-col w-64 sm:w-72 lg:w-80 
                    transform transition-transform duration-300 ease-in-out 
                    bg-white border-r border-gray-200 z-50 
                    lg:translate-x-0 lg:static">
            @include('artisan.dashboard.partials.sidebar')
        </nav>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('artisan.dashboard.partials.topbar')

            <!-- Dynamic Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="content-container">
                    <div x-show="currentTab === 'overview'"
                         x-transition.opacity.duration.500ms
                         class="dashboard-grid">
                        @include('artisan.dashboard.tabs.overview')
                    </div>

                    <div x-show="currentTab === 'projects'">
                        @include('artisan.dashboard.tabs.projects')
                    </div>

                    <div x-show="currentTab === 'calendar'">
                        @include('artisan.dashboard.tabs.calendar')
                    </div>

                    <div x-show="currentTab === 'messages'">
                        @include('artisan.dashboard.tabs.messages')
                    </div>

                    <div x-show="currentTab === 'reviews'">
                        @include('artisan.dashboard.tabs.reviews')
                    </div>

                    <div x-show="currentTab === 'settings'">
                        @include('artisan.dashboard.tabs.settings')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Notifications -->
    <div class="fixed bottom-4 right-4 z-50 space-y-4 w-full max-w-sm sm:max-w-md lg:max-w-lg"
         x-data="notifications"
         @notification.window="add($event.detail)">
        <template x-for="notification in list" :key="notification.id">
            <div x-show="notification.visible"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto border-l-4"
                 :class="{
                    'border-green-600': notification.type === 'success',
                    'border-red-600': notification.type === 'error',
                    'border-blue-600': notification.type === 'info'
                 }">
                <!-- Notification content -->
            </div>
        </template>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardState', () => ({
                sidebarOpen: false,
                currentTab: localStorage.getItem('dashboardTab') || 'overview',
                isMobile: window.innerWidth < 1024,

                init() {
                    this.checkScreenSize();
                    window.addEventListener('resize', () => this.checkScreenSize());
                },

                checkScreenSize() {
                    this.isMobile = window.innerWidth < 1024;
                    if (!this.isMobile) this.sidebarOpen = false;
                },

                setTab(tab) {
                    this.currentTab = tab;
                    localStorage.setItem('dashboardTab', tab);
                    if (this.isMobile) {
                        this.sidebarOpen = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>
