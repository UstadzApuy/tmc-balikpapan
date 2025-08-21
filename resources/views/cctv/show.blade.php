<!DOCTYPE html>
<html lang="en" x-data="cctvPlayer()">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $cctv->name }} - TMC Balikpapan</title>
  <link rel="icon" type="image/x-icon" href="/images/logo/tmc.png" />
  <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
  <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="relative w-full max-w-7xl h-[90vh] rounded-2xl overflow-hidden shadow-2xl shadow-slate-900/50 border border-slate-700/50">
      
      <!-- Header Overlay -->
      <div class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/80 to-transparent p-6 z-10">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-4">
            <button onclick="window.history.back()" class="text-white hover:text-slate-300 transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </button>
            <div>
              <h1 class="text-white text-2xl font-bold">{{ $cctv->name }}</h1>
              <p class="text-slate-300 text-sm flex items-center gap-2">
                <i class="fas fa-map-marker-alt"></i>
                {{ $cctv->location->name ?? 'Lokasi Tidak Diketahui' }}
              </p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="text-white text-sm font-medium">LIVE</span>
          </div>
        </div>
      </div>

      <!-- Video Container -->
      <div class="relative w-full h-full">
        @if($cctv->hls_url)
          <video 
            id="cctv-player" 
            class="video-js vjs-theme-modern w-full h-full" 
            controls 
            preload="auto"
            x-ref="videoPlayer"
            data-setup='{"fluid": true, "responsive": true}'>
            <source src="{{ $cctv->hls_url }}" type="application/x-mpegURL">
            <p class="vjs-no-js">
              To view this video please enable JavaScript, and consider upgrading to a web browser that
              <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
          </video>

          <!-- Loading State -->
          <div x-show="isLoading" class="absolute inset-0 bg-black/70 flex items-center justify-center">
            <div class="text-center">
              <div class="w-12 h-12 border-4 border-slate-600 border-t-slate-100 rounded-full animate-spin mx-auto mb-4"></div>
              <p class="text-white text-lg">Memuat streaming...</p>
            </div>
          </div>
        @elseif($cctv->rtsp_url)
          <div class="absolute inset-0 bg-slate-900/90 flex items-center justify-center">
            <div class="text-center text-white">
              <i class="fas fa-exclamation-triangle text-6xl text-amber-500 mb-4"></i>
              <h3 class="text-xl font-semibold mb-2">RTSP Stream Terdeteksi</h3>
              <p class="text-slate-300 mb-2">URL: {{ $cctv->rtsp_url }}</p>
              <p class="text-slate-400">Streaming RTSP memerlukan konversi ke HLS</p>
            </div>
          </div>
        @else
          <div class="absolute inset-0 bg-slate-900/90 flex items-center justify-center">
            <div class="text-center text-white">
              <i class="fas fa-video-slash text-6xl text-slate-500 mb-4"></i>
              <h3 class="text-xl font-semibold mb-2">Stream Tidak Tersedia</h3>
              <p class="text-slate-400">Tidak ada URL streaming yang tersedia</p>
            </div>
          </div>
        @endif
      </div>

      <!-- Control Bar Overlay -->
      <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 hover:opacity-100 transition-opacity duration-300">
        <div class="flex items-center gap-4 text-white">
          <button @click="togglePlayPause" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
            <i :class="isPlaying ? 'fas fa-pause' : 'fas fa-play'"></i>
          </button>
          <button @click="toggleMute" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
            <i :class="isMuted ? 'fas fa-volume-mute' : 'fas fa-volume-up'"></i>
          </button>
          <button @click="toggleFullscreen" class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition ml-auto">
            <i class="fas fa-expand"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function cctvPlayer() {
      return {
        isLoading: true,
        isPlaying: false,
        isMuted: false,
        player: null,
        
        init() {
          @if($cctv->hls_url)
            this.player = videojs('cctv-player', {
              controls: true,
              autoplay: false,
              preload: 'auto',
              fluid: true,
              responsive: true
            });
            
            this.player.ready(() => {
              this.isLoading = false;
            });
            
            this.player.on('playing', () => {
              this.isPlaying = true;
            });
            
            this.player.on('pause', () => {
              this.isPlaying = false;
            });
          @endif
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
        }
      }
    }
  </script>
</body>
</html>
