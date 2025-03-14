<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Artisan - {{ $title ?? 'Accueil' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        [x-cloak] { display: none !important; }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        @media (min-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        .card {
            @apply bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300;
        }

        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="h-full" x-data="dashboardState">
    <div class="min-h-full">
        <!-- Top Navigation -->
        @include('artisan.partials.top-nav')

        <!-- Sidebar & Main Content -->
        <div class="flex">
            <!-- Sidebar -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-700 overflow-y-auto lg:static lg:translate-x-0">
                @include('artisan.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1 min-w-0 flex flex-col">
                <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardState', () => ({
                sidebarOpen: false,
                currentTab: @json($currentTab ?? 'overview'),
                notifications: [],
                isMobile: window.innerWidth < 1024,

                init() {
                    this.checkScreenSize();
                    window.addEventListener('resize', () => this.checkScreenSize());

                    // Gestionnaire d'événements pour les notifications
                    window.addEventListener('notification', (event) => {
                        this.addNotification(event.detail);
                    });
                },

                checkScreenSize() {
                    this.isMobile = window.innerWidth < 1024;
                    if (!this.isMobile) this.sidebarOpen = false;
                },

                addNotification({ message, type = 'success', duration = 3000 }) {
                    const id = Date.now();
                    this.notifications.push({ id, message, type });
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, duration);
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            }));
        });
    </script>
</body>
</html>
