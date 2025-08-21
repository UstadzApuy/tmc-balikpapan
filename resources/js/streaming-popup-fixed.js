// Global streaming popup functionality for Alpine.js (fixed version)
window.streamingPopup = function () {
    return {
        // state
        openLocations: [],
        showPopup: false,
        popupTitle: '',
        popupLocation: '',
        hlsUrl: '',
        rtspUrl: '',
        hasHlsStream: false,
        hasRtspStream: false,
        isLoading: false,
        errorMessage: '',
        isMuted: false,

        // dragging
        isDragging: false,
        dragOffset: { x: 0, y: 0 },
        popupPosition: { x: 0, y: 0 },

        // player
        player: null,
        playerInitialized: false,

        // --- lifecycle ---
        init() {
            this.openLocations = [];
            // Escape key to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.showPopup) this.closePopup();
            });
        },

        // --- helpers ---
        getEventClient(event) {
            if (event?.touches && event.touches.length > 0) {
                return { x: event.touches[0].clientX, y: event.touches[0].clientY };
            }
            return { x: event?.clientX ?? 0, y: event?.clientY ?? 0 };
        },

        // Keep popup in viewport
        clampToViewport(pos, size) {
            const padding = 8;
            const maxX = Math.max(padding, window.innerWidth - size.width - padding);
            const maxY = Math.max(padding, window.innerHeight - size.height - padding);
            return {
                x: Math.min(Math.max(padding, pos.x), maxX),
                y: Math.min(Math.max(padding, pos.y), maxY)
            };
        },

        // --- accordion ---
        toggleLocation(locationId) {
            const i = this.openLocations.indexOf(locationId);
            if (i > -1) this.openLocations.splice(i, 1);
            else this.openLocations.push(locationId);
        },
        isOpen(locationId) {
            return this.openLocations.includes(locationId);
        },

        // --- open stream ---
        openStream(cctvId, cctvName, hlsUrl, rtspUrl, locationName, clickEvent = null) {
            // cleanup dulu
            this.closePopup();

            // Validate and format URLs
            const validHlsUrl = this.validateAndFormatUrl(hlsUrl);
            const validRtspUrl = this.validateAndFormatUrl(rtspUrl);

            // set data
            this.popupTitle = cctvName;
            this.popupLocation = locationName || '';
            this.hlsUrl = validHlsUrl;
            this.rtspUrl = validRtspUrl;
            this.hasHlsStream = !!validHlsUrl;
            this.hasRtspStream = !!validRtspUrl && !validHlsUrl;
            this.isLoading = !!validHlsUrl;
            this.errorMessage = '';
            this.isMuted = false;

            // hitung ukuran popup
            const popupWidth = Math.min(800, window.innerWidth - 32);
            const popupHeight = Math.min(520, window.innerHeight - 32);

            // tentukan posisi awal
            let x, y;
            if (clickEvent?.currentTarget) {
                const rect = clickEvent.currentTarget.getBoundingClientRect();
                x = rect.left + rect.width / 2 - popupWidth / 2;
                y = rect.top + 16;
            } else {
                x = window.innerWidth / 2 - popupWidth / 2;
                y = 120;
            }

            // clamp agar tetap terlihat
            const clamped = this.clampToViewport({ x, y }, { width: popupWidth, height: popupHeight });
            this.popupPosition = clamped;

            // tampilkan popup
            this.showPopup = true;

            // init video jika HLS ada
            if (this.hasHlsStream) {
                this.$nextTick(() => this.initVideoPlayer());
            }
        },

        // --- URL validation ---
        validateAndFormatUrl(url) {
            if (!url || typeof url !== 'string') return '';
            
            // Trim whitespace
            url = url.trim();
            
            // Check if it's a valid URL
            if (!url.startsWith('http') && !url.startsWith('//')) {
                // Try to fix relative URLs
                if (url.startsWith('/')) {
                    url = window.location.origin + url;
                } else {
                    return '';
                }
            }
            
            return url;
        },

        // --- video.js ---
        initVideoPlayer() {
            // dispose jika ada sebelumnya
            this.disposePlayer();

            const el = this.$refs.videoPlayer;
            if (!el || typeof videojs === 'undefined') {
                this.showErrorMessage('Video.js tidak tersedia');
                return;
            }

            // Create new player instance
            this.player = videojs(el, {
                controls: true,
                autoplay: false,
                preload: 'auto',
                fluid: true,
                responsive: true,
                html5: {
                    hls: {
                        overrideNative: true,
                        handlePartialData: true,
                        smoothQualityChange: true
                    }
                },
                techOrder: ['html5'],
                sources: [{
                    src: this.hlsUrl,
                    type: 'application/x-mpegURL'
                }]
            });

            // Add error handling
            this.player.ready(() => {
                this.player.on('error', (error) => {
                    console.error('Video.js error:', error);
                    const errorCode = this.player.error()?.code;
                    let message = 'Terjadi kesalahan saat memuat video';
                    
                    switch(errorCode) {
                        case 1:
                            message = 'Video tidak dapat dimuat, cek koneksi internet';
                            break;
                        case 2:
                            message = 'Jaringan bermasalah, coba lagi';
                            break;
                        case 3:
                            message = 'Video rusak atau tidak dapat diputar';
                            break;
                        case 4:
                            message = 'Format video tidak didukung atau URL tidak valid';
                            break;
                        case 5:
                            message = 'Video tidak dapat diputar di browser ini';
                            break;
                        default:
                            message = 'Terjadi kesalahan saat memuat video';
                    }
                    
                    this.showErrorMessage(message);
                });

                this.player.on('loadedmetadata', () => {
                    this.isLoading = false;
                    // Try to play after metadata is loaded
                    this.player.play().catch(e => {
                        console.log('Autoplay prevented:', e);
                        this.isLoading = false;
                    });
                });

                this.player.on('loadstart', () => {
                    this.isLoading = true;
                });
            });
        },

        disposePlayer() {
            if (this.player) {
                try {
                    this.player.dispose();
                } catch (e) {
                    console.warn('Error disposing player:', e);
                }
                this.player = null;
                this.playerInitialized = false;
            }
        },

        // --- controls overlays ---
        togglePlayPause() {
            if (!this.player) return;
            if (this.player.paused()) {
                this.player.play().catch(e => console.log('Play failed:', e));
            } else {
                this.player.pause();
            }
        },
        toggleMute() {
            if (!this.player) return;
            const now = !this.player.muted();
            this.player.muted(now);
            this.isMuted = now;
        },
        toggleFullscreen() {
            if (!this.player) return;
            if (this.player.isFullscreen()) {
                this.player.exitFullscreen();
            } else {
                this.player.requestFullscreen();
            }
        },

        // --- error ---
        showErrorMessage(message) {
            this.isLoading = false;
            this.errorMessage = message;
            console.error('Streaming error:', message);
        },

        // --- close & cleanup ---
        closePopup() {
            this.showPopup = false;
            this.errorMessage = '';
            this.isLoading = false;
            this.disposePlayer();
        },

        // --- dragging ---
        startDrag(event) {
            this.isDragging = true;
            const { x, y } = this.getEventClient(event);
            this.dragOffset = {
                x: x - this.popupPosition.x,
                y: y - this.popupPosition.y
            };

            this._dragHandler = (e) => this.drag(e);
            this._stopHandler = () => this.stopDrag();
            document.addEventListener('mousemove', this._dragHandler);
            document.addEventListener('mouseup', this._stopHandler);
            document.addEventListener('touchmove', this._dragHandler, { passive: false });
            document.addEventListener('touchend', this._stopHandler);
        },

        drag(event) {
            if (!this.isDragging) return;
            const { x, y } = this.getEventClient(event);
            const popupWidth = Math.min(800, window.innerWidth - 32);
            const popupHeight = Math.min(520, window.innerHeight - 32);
            const next = { x: x - this.dragOffset.x, y: y - this.dragOffset.y };
            this.popupPosition = this.clampToViewport(next, { width: popupWidth, height: popupHeight });
            if (event.cancelable) event.preventDefault();
        },

        stopDrag() {
            this.isDragging = false;
            document.removeEventListener('mousemove', this._dragHandler);
            document.removeEventListener('mouseup', this._stopHandler);
            document.removeEventListener('touchmove', this._dragHandler);
            document.removeEventListener('touchend', this._stopHandler);
        }
    };
};

// Register the streamingPopup function globally for Alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.data('streamingPopup', window.streamingPopup);
});
