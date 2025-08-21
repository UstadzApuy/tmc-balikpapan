 <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TMC Balikpapan</title>
  <link rel="icon" type="image/x-icon" href="/images/logo/tmc.png" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    @keyframes marquee {
      0% { transform: translateX(0%); }
      100% { transform: translateX(-50%); }
    }
    .animate-marquee {
      animation: marquee 30s linear infinite;
      display: inline-block;
    }
    .marquee-content {
      display: inline-block;
      white-space: nowrap;
    }
    body {
      background-image: url('/images/bg/batik.png');
      background-size: 300px 300px;
      background-repeat: repeat;
      background-attachment: fixed;
      background-position: top left;
    }
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(248, 250, 252, 0.85);
      z-index: -1;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex relative" 
      x-data="{ 
        open: false, 
        hoverOpen: false, 
        mobileMenuOpen: false,
        news: [],
        currentTime: '',
        ...scrollNavigation() 
      }" 
  x-init="
  const updateTime = () => {
    const now = new Date(new Date().getTime() + (1 * 60 * 60 * 1000)); // UTC+8
    if (window.innerWidth <= 768) {
      currentTime = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long' }) 
                    + ' ' 
                    + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
    } else {
      currentTime = now.toLocaleString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      });
    }
  };
  updateTime();
  setInterval(updateTime, 1000);
">
  <!-- Mobile Sidebar -->
  <aside x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed left-0 z-[9999] w-64 bg-[#30318B] text-white shadow-lg md:hidden"
         style="top: 112px; bottom: 0;">
    <div class="flex flex-col h-full">
      <!-- Logo -->
      <div class="flex items-center justify-center h-16 border-b border-gray-600">
        <img src="/images/logo/tmc.png" alt="TMC" class="w-10 h-10">
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto mt-4">
        <ul class="space-y-1 px-2">
          <li>
            <a href="#home" @click.prevent="scrollToSection('home'); mobileMenuOpen = false"
               :class="isActive('home') ? 'bg-[#FEC800] text-black' : ''"
               class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
              <!-- Home -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
              </svg>
              <span>Home</span>
            </a>
          </li>
          <li>
            <a href="#map" @click.prevent="scrollToSection('map'); mobileMenuOpen = false"
               :class="isActive('map') ? 'bg-[#FEC800] text-black' : ''"
               class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
              <!-- Map -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-.553 1.894L15 20l-6-3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
              </svg>
              <span>Map</span>
            </a>
          </li>
          <li>
            <a href="#streaming" @click.prevent="scrollToSection('streaming'); mobileMenuOpen = false"
               :class="isActive('streaming') ? 'bg-[#FEC800] text-black' : ''"
               class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
              <!-- Streaming -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-4.197-2.432A1 1 0 009 9.618v4.764a1 1 0 001.555.832l4.197-2.432a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>Streaming</span>
            </a>
          </li>
          <li>
            <a href="#contact" @click.prevent="scrollToSection('contact'); mobileMenuOpen = false"
               :class="isActive('contact') ? 'bg-[#FEC800] text-black' : ''"
               class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
              <!-- Kontak -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.69l1.52 4.56a1 1 0 01-.5 1.2l-2.25 1.12a11.05 11.05 0 005.5 5.5l1.12-2.25a1 1 0 011.2-.5l4.56 1.52a1 1 0 01.69.95V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z"/>
              </svg>
              <span>Kontak Kami</span>
            </a>
          </li>
          @auth
            <li>
              <a href="/admin"
                 class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
                <!-- Admin -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1117.803 5.12M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7m0 0h7m-7 0H5"/>
                </svg>
                <span>Admin</span>
              </a>
            </li>
          @endauth
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Mobile Menu Overlay -->
  <div x-show="mobileMenuOpen" 
       class="fixed inset-0 z-45 md:hidden bg-black bg-opacity-50"
       @click="mobileMenuOpen = false"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-300"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0">
  </div>

  <!-- Fixed Topbar -->
  <div class="fixed top-0 left-0 right-0 z-50">
    <!-- First Topbar - Clock -->
    <div class="bg-black text-white py-2 px-4 flex justify-center items-center">
      <div class="text-sm md:text-lg font-semibold tracking-wide text-center" x-text="currentTime"></div>
      <div class="absolute right-4 md:right-6">
        @auth
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-white hover:text-gray-300 text-xs md:text-base">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="text-white hover:text-gray-300 ml-2 md:ml-4 text-xs md:text-base">Login</a>
        @endauth
      </div>
    </div>
    <!-- Second Topbar - News -->
    @php
        // Gunakan cache untuk berita yang dipilih admin
        $cacheKey = 'selected_news_global';
        $selectedNews = null;
        $content = '';
        
        // Cek cache untuk berita yang dipilih
        $selectedNewsId = cache($cacheKey);
        if (!$selectedNewsId) {
            // Fallback ke session jika cache tidak ada
            $selectedNewsId = session('selected_news_id');
        }
        
        // Cek jika ada berita yang dipilih admin
        if ($selectedNewsId) {
            $selectedNews = \App\Models\News::find($selectedNewsId);
            if ($selectedNews && $selectedNews->is_active) {
                $content = $selectedNews->content;
                
                // Handle location scope based on cache/session data
                $scope = cache('selected_scope') ?? session('selected_scope');
                $locationNames = '';
                
                if ($scope === 'city') {
                    $locationNames = 'Seluruh Kota Balikpapan';
                } elseif ($scope === 'kecamatan') {
                    $selectedKecamatan = cache('selected_kecamatan') ?? session('selected_kecamatan', []);
                    if (!empty($selectedKecamatan)) {
                        $locationNames = 'Kecamatan: ' . implode(', ', $selectedKecamatan);
                    }
                } elseif ($scope === 'area') {
                    $selectedLocations = cache('selected_locations') ?? session('selected_locations', []);
                    if (!empty($selectedLocations)) {
                        $locations = \App\Models\Location::whereIn('id', $selectedLocations)->get();
                        $locationNames = $locations->pluck('name')->implode(', ');
                    }
                }
                
                // Append location information for ALL news
                if (!empty($locationNames)) {
                    $content .= ' | ' . $locationNames;
                }
            }
        }
        
        // Jika tidak ada berita yang dipilih admin, gunakan berita default
        if (!$selectedNews) {
            $selectedNews = \App\Models\News::where('is_active', true)
                ->where('title', 'Informasi TMC')
                ->first();
            
            if (!$selectedNews) {
                $selectedNews = \App\Models\News::where('is_active', true)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }
            
            if ($selectedNews) {
                $content = $selectedNews->content;
                $locationNames = 'Seluruh Kota Balikpapan';
                
                // Cek apakah berita memiliki lokasi spesifik
                if ($selectedNews->locations()->count() > 0) {
                    $locations = $selectedNews->locations()->pluck('name')->toArray();
                    $locationNames = implode(', ', $locations);
                }
                
                if (!empty($locationNames)) {
                    $content .= ' | ' . $locationNames;
                }
            }
        }
        
        $weatherCondition = $selectedNews ? $selectedNews->weather_condition : 'info';
        $bgColor = match($weatherCondition) {
            'banjir' => 'bg-red-600 text-white',
            'hujan' => 'bg-blue-600 text-white',
            'kemacetan' => 'bg-yellow-600 text-black',
            'kepadatan' => 'bg-orange-600 text-white',
            'info' => 'bg-green-600 text-white',
            default => 'bg-gray-600 text-white'
        };
    @endphp
    
    <div class="{{ $bgColor }} py-2 px-4 md:px-6 shadow-md flex justify-center items-center">
      <div class="relative overflow-hidden w-full h-8 flex items-center">
        @if($selectedNews)
            <div class="marquee-container whitespace-nowrap">
                <div class="marquee-content animate-marquee inline-block">
                    <span class="text-sm leading-none">
                        {{ $content }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class="text-sm leading-none">
                        {{ $content }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                </div>
            </div>
        @else
          <div class="w-full text-center text-sm leading-none">
            Tidak ada berita aktif saat ini.
          </div>
        @endif
      </div>
    </div>
  </div>
  
  <!-- Desktop Sidebar -->
  <aside class="hidden md:block fixed left-0 top-0 h-screen bg-[#30318B] text-white shadow-lg transition-[width] duration-400 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] flex flex-col z-50"
         :class="open || hoverOpen ? 'w-64' : 'w-20'"
         @mouseenter="hoverOpen = true"
         @mouseleave="hoverOpen = false">
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16">
      <img src="/images/logo/tmc.png" alt="TMC" class="w-10 h-10">
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto mt-4">
      <ul class="space-y-1">
        <li>
          <a href="#home" @click.prevent="scrollToSection('home')"
             :class="isActive('home') ? 'bg-[#FEC800] text-black' : ''"
             class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
            <!-- Home -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            </svg>
            <span x-show="open || hoverOpen">Home</span>
          </a>
        </li>
        <li>
          <a href="#map" @click.prevent="scrollToSection('map')"
             :class="isActive('map') ? 'bg-[#FEC800] text-black' : ''"
             class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
            <!-- Map -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-.553 1.894L15 20l-6-3z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
            </svg>
            <span x-show="open || hoverOpen">Map</span>
          </a>
        </li>
        <li>
          <a href="#streaming" @click.prevent="scrollToSection('streaming')"
             :class="isActive('streaming') ? 'bg-[#FEC800] text-black' : ''"
             class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
            <!-- Streaming -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-4.197-2.432A1 1 0 009 9.618v4.764a1 1 0 001.555.832l4.197-2.432a1 1 0 000-1.664z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-show="open || hoverOpen">Streaming</span>
          </a>
        </li>
        <li>
          <a href="#contact" @click.prevent="scrollToSection('contact')"
             :class="isActive('contact') ? 'bg-[#FEC800] text-black' : ''"
             class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
            <!-- Kontak -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.69l1.52 4.56a1 1 0 01-.5 1.2l-2.25 1.12a11.05 11.05 0 005.5 5.5l1.12-2.25a1 1 0 011.2-.5l4.56 1.52a1 1 0 01.69.95V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z"/>
            </svg>
            <span x-show="open || hoverOpen">Kontak Kami</span>
          </a>
        </li>
        @auth
          <li>
            <a href="/admin"
               class="flex items-center gap-3 p-3 pl-6 hover:bg-[#FEC800] hover:text-black rounded-md transition-all duration-300">
              <!-- Admin -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1117.803 5.12M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7m0 0h7m-7 0H5"/>
              </svg>
              <span x-show="open || hoverOpen">Admin</span>
            </a>
          </li>
        @endauth
      </ul>
    </nav>
  </aside>

  <!-- Mobile Header with Hamburger Menu -->
  <header class="md:hidden fixed top-16 left-0 right-0 bg-[#30318B] text-white shadow-lg z-20">
    <div class="flex items-center justify-between p-4">
      <img src="/images/logo/tmc.png" alt="TMC" class="w-8 h-8">
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 md:ml-20 transition-[margin-left] duration-400 ease-[cubic-bezier(0.25,0.46,0.45,0.94)] overflow-x-hidden z-0" 
        :class="open || hoverOpen ? 'md:ml-64' : 'md:ml-20'">
    <div class="pt-28 md:pt-28 px-4">
      @yield('content')
    </div>
  </main>

    <!-- Alpine.js Scroll Navigation -->
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('scrollNavigation', () => ({
        activeSection: 'home',
        sections: ['home', 'map', 'streaming', 'contact'],
        
        scrollToSection(sectionId) {
          const element = document.getElementById(sectionId);
          if (element) {
            const offsetTop = element.offsetTop - (window.innerWidth < 768 ? 112 : 112);
            window.scrollTo({
              top: offsetTop,
              behavior: 'smooth'
            });
            this.activeSection = sectionId;
          }
        },
        
        isActive(sectionId) {
          return this.activeSection === sectionId;
        }
      }));
    });

    window.addEventListener('newsUpdated', function(e) {
      setTimeout(() => {
        location.reload();
      }, 500);
    });

    setInterval(() => {
      const lastUpdated = sessionStorage.getItem('last_updated');
      const currentLastUpdated = {{ session('last_updated', '0') }};
      if (lastUpdated && parseInt(lastUpdated) > parseInt(currentLastUpdated)) {
        location.reload();
      }
    }, 3000);
  </script>
</body>
</html>