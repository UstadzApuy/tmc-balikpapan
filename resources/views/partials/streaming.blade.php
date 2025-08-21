<div class="max-w-6xl mx-auto px-4 py-6" x-data="streamingPopup()">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Streaming CCTV</h2>

    <div class="space-y-10">
        @foreach($groupedByKecamatan as $kecamatan => $locations)
            <section>
                <h3 class="text-xl font-bold mb-5 text-gray-700 border-b pb-1">{{ $kecamatan }}</h3>
                <div class="grid gap-5 md:grid-cols-1">
                    @foreach($locations as $loc)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden transition hover:shadow-md">
                            <button
                                @click="toggleLocation({{ $loc->id }})"
                                class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition"
                                aria-label="Toggle lokasi {{ $loc->name }}"
                            >
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-800">{{ $loc->name }}</p>
                                    @if($loc->latitude && $loc->longitude)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $loc->latitude }}, {{ $loc->longitude }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs px-2 py-0.5 bg-gray-100 rounded-full">{{ $loc->cctvs->count() }} CCTV</span>
                                    <svg :class="isOpen({{ $loc->id }}) ? 'rotate-180' : ''"
                                         class="w-5 h-5 text-gray-500 transform transition-transform duration-300"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>

                            <div x-show="isOpen({{ $loc->id }})" x-transition class="px-5 pb-4" x-cloak>
                                <ul class="divide-y divide-gray-100">
                                    @foreach($loc->cctvs as $c)
                                        <li class="py-3 flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $c->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $c->camera_type }} • {{ $c->status }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    @click="openStream({{ $c->id }}, '{{ addslashes($c->name) }}', '{{ addslashes($c->hls_url ?? '') }}', '{{ addslashes($c->rtsp_url ?? '') }}', '{{ addslashes($c->location->name ?? 'Lokasi Tidak Diketahui') }}', $event)"
                                                    class="px-3 py-1.5 bg-[#30318B] text-white rounded text-xs hover:opacity-90"
                                                    aria-label="Buka live {{ addslashes($c->name) }}"
                                                >
                                                    Live
                                                </button>
                                                <a href="{{ route('cctv.show', ['id' => $c->id]) }}"
                                                   class="text-xs text-gray-500 hover:text-gray-700">Detail</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    <!-- Popup Backdrop -->
    <div
        x-show="showPopup"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 bg-black/50 z-50"
        @click.self="closePopup"
        aria-hidden="true"
    ></div>

    <!-- Draggable Popup Window -->
    <div
        x-show="showPopup"
        x-cloak
        class="fixed z-[60] w-[90vw] max-w-[800px] max-h-[90vh] bg-slate-900 rounded-xl shadow-2xl overflow-hidden"
        :style="`left:${popupPosition.x}px; top:${popupPosition.y}px;`"
        role="dialog"
        aria-modal="true"
        aria-label="Streaming popup"
    >
        <!-- Popup Header -->
        <div
            class="bg-gradient-to-b from-black/80 to-transparent p-3 sm:p-4 flex items-center justify-between cursor-move select-none"
            @mousedown="startDrag($event)"
            @touchstart="startDrag($event)"
        >
            <div class="flex items-center gap-3 min-w-0">
                <button @click="closePopup" class="text-white/90 hover:text-slate-300 transition" aria-label="Tutup popup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-white text-base sm:text-lg font-bold truncate" x-text="popupTitle"></h1>
                    <p class="text-slate-300 text-xs sm:text-sm truncate">
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
        <div class="w-full h-auto sm:h-[450px] relative bg-black">
            <!-- Video Container -->
            <div class="relative w-full h-full">
                <!-- HLS Stream -->
                <template x-if="hasHlsStream">
                    <video
                        x-ref="videoPlayer"
                        class="video-js vjs-theme-modern w-full h-full object-contain"
                        controls
                        preload="auto"
                        playsinline
                        aria-label="Pemutar video"
                    ></video>
                </template>

                <!-- RTSP Stream Info -->
                <div x-show="hasRtspStream" class="absolute inset-0 bg-slate-900/90 flex items-center justify-center p-4 text-center">
                    <div class="text-white">
                        <i class="fas fa-exclamation-triangle text-4xl sm:text-6xl text-amber-500 mb-3"></i>
                        <h3 class="text-base sm:text-xl font-semibold mb-1">RTSP Stream Terdeteksi</h3>
                        <p class="text-slate-300 text-xs sm:text-sm break-all mb-1" x-text="'URL: ' + rtspUrl"></p>
                        <p class="text-slate-400 text-xs sm:text-sm">Streaming RTSP memerlukan konversi ke HLS</p>
                    </div>
                </div>

                <!-- No Stream Available -->
                <div x-show="!hasHlsStream && !hasRtspStream" class="absolute inset-0 bg-slate-900/90 flex items-center justify-center p-4 text-center">
                    <div class="text-white">
                        <i class="fas fa-video-slash text-4xl sm:text-6xl text-slate-500 mb-3"></i>
                        <h3 class="text-base sm:text-xl font-semibold mb-1">Stream Tidak Tersedia</h3>
                        <p class="text-slate-400 text-xs sm:text-sm">Tidak ada URL streaming yang tersedia</p>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="isLoading" class="absolute inset-0 bg-black/70 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 border-4 border-slate-600 border-t-slate-100 rounded-full animate-spin mx-auto mb-3"></div>
                        <p class="text-white text-sm sm:text-base">Memuat streaming...</p>
                    </div>
                </div>

                <!-- Error Overlay -->
                <div x-show="errorMessage" class="absolute inset-0 bg-black/80 flex items-center justify-center p-4">
                    <p class="text-red-300 text-sm sm:text-base text-center" x-text="errorMessage"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Video.js -->
    <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
    <script src="https://unpkg.com/@videojs/http-streaming@3.0.0/dist/videojs-http-streaming.min.js"></script>
    <script src="{{ asset('js/streaming-popup-fixed.js') }}"></script>
</div>
