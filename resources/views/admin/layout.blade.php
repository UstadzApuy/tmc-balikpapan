<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - TMC Balikpapan')</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/tmc.png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Prevent horizontal overflow */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }
        
        /* Mobile menu overlay */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 30;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Sidebar transitions */
        .sidebar {
            transition: transform 0.3s ease;
        }
        
        /* Main content transitions */
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .topbar {
                left: 0 !important;
                right: 0 !important;
            }
            
            /* Prevent content overflow */
            .container-mobile {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar {
                transform: none !important;
            }
            
            .mobile-menu-overlay {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50" x-data="{ 
    sidebarOpen: false, 
    hoverOpen: false,
    isMobile: window.innerWidth < 768,
    init() {
        this.checkMobile();
        window.addEventListener('resize', () => {
            this.checkMobile();
            if (!this.isMobile) {
                this.sidebarOpen = false;
            }
        });
    },
    checkMobile() {
        this.isMobile = window.innerWidth < 768;
    }
}">
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" 
         :class="{ 'active': sidebarOpen && isMobile }"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <aside class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-[#30318B] text-white shadow-lg md:w-20 md:hover:w-64 md:transition-[width] md:duration-300"
           :class="{ 'active': sidebarOpen }"
           @mouseenter="!isMobile ? hoverOpen = true : null"
           @mouseleave="!isMobile ? hoverOpen = false : null">
        
        <!-- Logo & Close Button -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-[#FEC800]/20">
            <div class="flex items-center">
                <img src="/images/logo/tmc.png" alt="TMC" class="w-8 h-8">
                <span class="ml-2 text-white font-bold text-lg" x-show="isMobile || hoverOpen || sidebarOpen">Admin TMC</span>
            </div>
            <button @click="sidebarOpen = false" class="text-white md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ url('/admin') }}" 
               class="flex items-center px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200"
               :class="{ 'bg-[#FEC800] text-black': window.location.pathname === '/admin' }">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                <span x-show="isMobile || hoverOpen || sidebarOpen">Dashboard</span>
            </a>

            <!-- Locations -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-show="isMobile || hoverOpen || sidebarOpen">Lokasi</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-show="isMobile || hoverOpen || sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.locations.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        📍 Semua Lokasi
                    </a>
                    <a href="{{ route('admin.locations.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        ➕ Tambah Lokasi
                    </a>
                </div>
            </div>

            <!-- CCTV -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-.553.894l-5 2.5a1 1 0 01-.894 0l-5-2.5A1 1 0 019 15.382V8.618a1 1 0 01.553-.894l5-2.5a1 1 0 01.894 0z"></path>
                        </svg>
                        <span x-show="isMobile || hoverOpen || sidebarOpen">CCTV</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-show="isMobile || hoverOpen || sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.cctvs.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        📹 Semua CCTV
                    </a>
                    <a href="{{ route('admin.cctvs.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        ➕ Tambah CCTV
                    </a>
                </div>
            </div>

            <!-- Contacts -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="isMobile || hoverOpen || sidebarOpen">Kontak</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-show="isMobile || hoverOpen || sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        📞 Semua Kontak
                    </a>
                </div>
            </div>

            <!-- News -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span x-show="isMobile || hoverOpen || sidebarOpen">Berita</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-show="isMobile || hoverOpen || sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.news.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        📰 Semua Berita
                    </a>
                    <a href="{{ route('admin.news.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        ➕ Tambah Berita
                    </a>
                </div>
            </div>

            <!-- User Management -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="isMobile || hoverOpen || sidebarOpen">User</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-show="isMobile || hoverOpen || sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.users.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        👥 Semua User
                    </a>
                    <a href="{{ route('admin.users.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#FEC800]/20 rounded-md transition-colors">
                        ➕ Tambah User
                    </a>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-[#FEC800]/20 my-4" x-show="isMobile || hoverOpen || sidebarOpen">

            <!-- Quick Actions -->
            <div class="text-xs text-gray-400 px-4 py-2" x-show="isMobile || hoverOpen || sidebarOpen">Aksi Cepat</div>
            <a href="{{ url('/') }}" 
               class="flex items-center px-4 py-3 text-sm rounded-lg text-white hover:bg-[#FEC800] hover:text-black transition-all duration-200">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span x-show="isMobile || hoverOpen || sidebarOpen">Kembali ke Home</span>
            </a>
        </nav>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 left-0 right-0 bg-[#30318B] text-white shadow-lg z-30">
        <div class="flex items-center justify-between p-4">
            <img src="/images/logo/tmc.png" alt="TMC" class="w-8 h-8">
            <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Main content -->
    <div class="main-content flex-1 flex flex-col md:ml-20">
        <!-- Top bar -->
        <header class="topbar bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-20"
                :class="isMobile ? 'left-0' : 'left-20'">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="ml-2 text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500 hidden sm:block">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto mt-16">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition
                             class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" 
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <button @click="show = false" class="inline-flex text-green-400 hover:text-green-500">
                                        <span class="sr-only">Close</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" 
                                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" 
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
