<div class="max-w-7xl mx-auto px-4 py-6" x-data="mapStreamingData()">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-lg mx-auto">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Peta Lokasi CCTV
            </h2>
            <p class="text-gray-600 mt-1">Pilih lokasi untuk melihat daftar CCTV yang tersedia</p>
        </div>

        <!-- Map Container -->
        <div class="relative">
            <div id="map-container" class="w-full h-[600px] rounded-b-lg"></div>
            
            <!-- Loading Overlay -->
            <div id="map-loading" class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-b-lg">
                <div class="text-center">
                    <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-gray-600">Memuat peta...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Draggable Popup Window with Detailed Info -->
    <div
        x-show="showPopup"
        x-transition
        class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        @click.self="closePopup"
    >
        <div
            class="relative bg-slate-900 rounded-lg shadow-2xl overflow-hidden w-full max-w-4xl"
            :class="{'max-w-full max-h-full': isMobile, 'max-w-4xl': !isMobile}"
            :style="!isMobile ? popupStyle : ''"
            @mousedown="!isMobile ? startDrag($event) : ''"
            @mousemove="!isMobile ? drag($event) : ''"
            @mouseup="!isMobile ? stopDrag($event) : ''"
            @mouseleave="!isMobile ? stopDrag($event) : ''"
            @touchstart="isMobile ? startDrag($event) : ''"
            @touchmove="isMobile ? drag($event) : ''"
            @touchend="isMobile ? stopDrag($event) : ''"
        >
            <!-- Popup Header -->
            <div class="bg-gradient-to-b from-black/80 to-transparent p-4 z-10 cursor-move flex items-center justify-between" 
                 :class="{'cursor-move': !isMobile, 'cursor-default': isMobile}">
                <div class="flex items-center gap-3">
                    <button @click="closePopup" class="text-white hover:text-slate-300 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-white text-lg sm:text-xl font-bold" x-text="popupTitle"></h1>
                        <p class="text-slate-300 text-xs sm:text-sm flex items-center gap-1">
                            <i class="fas fa-map-marker-alt"></i>
                            <span x-text="popupLocation"></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-white text-xs sm:text-sm font-medium">LIVE</span>
                </div>
            </div>

            <!-- Popup Content -->
            <div class="w-full h-auto sm:h-[450px]">
                <!-- Video Container -->
                <div class="relative w-full aspect-video sm:aspect-auto sm:h-full">
                    <!-- HLS Stream -->
                    <div x-show="hasHlsStream" class="relative w-full h-full">
                        <video 
                            x-ref="videoPlayer"
                            class="video-js vjs-theme-modern w-full h-full"
                            controls
                            preload="auto"
                            data-setup='{"fluid": true, "responsive": true}'
                        >
                            <source x-bind:src="hlsUrl" type="application/x-mpegURL">
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                            </p>
                        </video>

                        <!-- Loading State -->
                        <div x-show="isLoading" class="absolute inset-0 bg-black/70 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-8 h-8 sm:w-12 sm:h-12 border-4 border-slate-600 border-t-slate-100 rounded-full animate-spin mx-auto mb-2 sm:mb-4"></div>
                                <p class="text-white text-sm sm:text-lg">Memuat streaming...</p>
                            </div>
                        </div>
                    </div>

                    <!-- RTSP Stream Info -->
                    <div x-show="hasRtspStream" class="absolute inset-0 bg-slate-900/90 flex items-center justify-center">
                        <div class="text-center text-white p-4">
                            <i class="fas fa-exclamation-triangle text-4xl sm:text-6xl text-amber-500 mb-2 sm:mb-4"></i>
                            <h3 class="text-base sm:text-xl font-semibold mb-1 sm:mb-2">RTSP Stream Terdeteksi</h3>
                            <p class="text-slate-300 text-xs sm:text-sm mb-1 sm:mb-2" x-text="'URL: ' + rtspUrl"></p>
                            <p class="text-slate-400 text-xs sm:text-sm">Streaming RTSP memerlukan konversi ke HLS</p>
                        </div>
                    </div>

                    <!-- No Stream Available -->
                    <div x-show="!hasHlsStream && !hasRtspStream" class="absolute inset-0 bg-slate-900/90 flex items-center justify-center">
                        <div class="text-center text-white p-4">
                            <i class="fas fa-video-slash text-4xl sm:text-6xl text-slate-500 mb-2 sm:mb-4"></i>
                            <h3 class="text-base sm:text-xl font-semibold mb-1 sm:mb-2">Stream Tidak Tersedia</h3>
                            <p class="text-slate-400 text-xs sm:text-sm">Tidak ada URL streaming yang tersedia</p>
                        </div>
                    </div>

                    <!-- Control Bar Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3 sm:p-6 opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="flex items-center gap-2 sm:gap-4 text-white">
                            <button @click="togglePlayPause" class="p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                                <i :class="isPlaying ? 'fas fa-pause text-sm sm:text-base' : 'fas fa-play text-sm sm:text-base'"></i>
                            </button>
                            <button @click="toggleMute" class="p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                                <i :class="isMuted ? 'fas fa-volume-mute text-sm sm:text-base' : 'fas fa-volume-up text-sm sm:text-base'"></i>
                            </button>
                            <button @click="toggleFullscreen" class="p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition ml-auto">
                                <i class="fas fa-expand text-sm sm:text-base"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Video.js -->
    <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>

    <script>
    let map;
    let markers = [];

    // Initialize map
    function initMap() {
        // Default center on Balikpapan
        const defaultCenter = [-1.2379, 116.8528];
        
        map = L.map('map-container').setView(defaultCenter, 12);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Load locations with CCTV data
        loadLocationsWithCctv();
    }

    // Load locations with their CCTV data
    function loadLocationsWithCctv() {
        try {
            // Get locations data from server-side
            const locations = @json($locations->load('cctvs'));
            
            console.log('Loaded locations with CCTV:', locations);
            
            if (locations && locations.length > 0) {
                locations.forEach(location => {
                    if (location.latitude && location.longitude) {
                        // Create marker for location
                        const marker = L.marker([location.latitude, location.longitude], {
                            icon: L.icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            })
                        }).addTo(map);

                        // Create popup content with CCTV list
                        let popupContent = `
                            <div class="space-y-2">
                                <div class="font-semibold text-gray-800 mb-2">${location.name}</div>
                                <div class="text-sm text-gray-600 mb-2">${location.kecamatan}</div>
                        `;

                        if (location.cctvs && location.cctvs.length > 0) {
                            popupContent += location.cctvs.map(cctv => `
                                <button onclick="openCctvStream(${cctv.id}, '${cctv.name}', '${cctv.hls_url || ''}', '${cctv.rtsp_url || ''}', '${location.name}')" 
                                        class="block w-full text-left px-3 py-1.5 bg-blue-600 text-white rounded text-sm mb-1 hover:bg-blue-700 transition">
                                    ${cctv.name}
                                </button>
                            `).join('');
                        } else {
                            popupContent += `
                                <div class="text-sm text-gray-500 italic">
                                    Tidak ada CCTV di lokasi ini
                                </div>
                            `;
                        }

                        popupContent += '</div>';

                        // Bind popup to marker
                        marker.bindPopup(popupContent, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });
                        
                        markers.push(marker);
                    }
                });

                // Fit map to show all markers
                if (markers.length > 0) {
                    const group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
                
                // Hide loading overlay
                document.getElementById('map-loading').style.display = 'none';
            } else {
                console.warn('No locations found');
                document.getElementById('map-loading').innerHTML = 
                    '<p class="text-yellow-600">Tidak ada data lokasi yang tersedia</p>';
            }
            
        } catch (error) {
            console.error('Error loading locations:', error);
            document.getElementById('map-loading').innerHTML = 
                '<p class="text-red-500">Gagal memuat peta. Silakan refresh halaman.</p>';
        }
    }

    // Global function to open CCTV stream popup
    function openCctvStream(cctvId, cctvName, hlsUrl, rtspUrl, locationName) {
        // Dispatch custom event to trigger Alpine.js popup
        const event = new CustomEvent('open-cctv-stream', {
            detail: {
                cctvId: cctvId,
                cctvName: cctvName,
                hlsUrl: hlsUrl,
                rtspUrl: rtspUrl,
                locationName: locationName
            }
        });
        document.dispatchEvent(event);
    }

    // Alpine.js component for map streaming
    function mapStreamingData() {
        return {
            openLocations: [],
            showPopup: false,
            popupTitle: '',
            popupLocation: '',
            hlsUrl: '',
            rtspUrl: '',
            hasHlsStream: false,
            hasRtspStream: false,
            isLoading: true,
            isPlaying: false,
            isMuted: false,
            isMobile: false,
            isDragging: false,
            dragOffset: { x: 0, y: 0 },
            popupPosition: { x: 100, y: 100 },
            player: null,

            init() {
                // Listen for custom events from map
                document.addEventListener('open-cctv-stream', (event) => {
                    this.openStream(
                        event.detail.cctvId,
                        event.detail.cctvName,
                        event.detail.hlsUrl,
                        event.detail.rtspUrl,
                        event.detail.locationName
                    );
                });
                this.checkMobile();
                window.addEventListener('resize', () => this.checkMobile());
            },

            checkMobile() {
                this.isMobile = window.innerWidth <= 768;
                if (this.isMobile) {
                    this.popupPosition = { x: 0, y: 0 };
                }
            },

            get popupStyle() {
                if (this.isMobile) {
                    return '';
                }
                const maxX = Math.max(0, window.innerWidth - 800);
                const maxY = Math.max(0, window.innerHeight - 450);
                const x = Math.min(Math.max(0, this.popupPosition.x), maxX);
                const y = Math.min(Math.max(0, this.popupPosition.y), maxY);
                return `left: ${x}px; top: ${y}px;`;
            },

            openStream(cctvId, cctvName, hlsUrl, rtspUrl, locationName) {
                this.popupTitle = cctvName;
                this.popupLocation = locationName;
                this.hlsUrl = hlsUrl;
                this.rtspUrl = rtspUrl;
                this.hasHlsStream = !!hlsUrl;
                this.hasRtspStream = !!rtspUrl;
                this.showPopup = true;
                this.isLoading = true;

                // Initialize video player if HLS URL is available
                if (hlsUrl) {
                    this.$nextTick(() => {
                        this.initVideoPlayer();
                    });
                }
            },

            initVideoPlayer() {
                if (this.player) {
                    this.player.dispose();
                }
                
                if (typeof videojs !== 'undefined') {
                    this.player = videojs(this.$refs.videoPlayer, {
                        controls: true,
                        autoplay: true,
                        preload: 'auto',
                        fluid: true,
                        responsive: true
                    });
                    
                    this.player.ready(() => {
                        this.isLoading = false;
                    });
                }
            },

            togglePlayPause() {
                if (this.player) {
                    if (this.player.paused()) {
                        this.player.play();
                    } else {
                        this.player.pause();
                    }
                }
            },

            toggleMute() {
                if (this.player) {
                    if (this.player.muted()) {
                        this.player.muted(false);
                        this.isMuted = false;
                    } else {
                        this.player.muted(true);
                        this.isMuted = true;
                    }
                }
            },

            toggleFullscreen() {
                if (this.player) {
                    if (this.player.isFullscreen()) {
                        this.player.exitFullscreen();
                    } else {
                        this.player.requestFullscreen();
                    }
                }
            },

            closePopup() {
                this.showPopup = false;
                if (this.player) {
                    this.player.dispose();
                    this.player = null;
                }
            },

            startDrag(event) {
                this.isDragging = true;
                const clientX = event.clientX;
                const clientY = event.clientY;
                
                this.dragOffset = {
                    x: clientX - this.popupPosition.x,
                    y: clientY - this.popupPosition.y
                };
            },

            drag(event) {
                if (!this.isDragging) return;
                
                const clientX = event.clientX;
                const clientY = event.clientY;
                
                this.popupPosition = {
                    x: clientX - this.dragOffset.x,
                    y: clientY - this.dragOffset.y
                };
            },

            stopDrag() {
                this.isDragging = false;
            }
        };
    }

    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', initMap);
    </script>

    <style>
    /* Custom popup styling */
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .custom-popup .leaflet-popup-content {
        margin: 12px 16px;
        line-height: 1.5;
    }
    </style>
