// Global streaming popup functionality for Alpine.js (final)
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
        /**
         * @param {Number} cctvId
         * @param {String} cctvName
         * @param {String} hlsUrl
         * @param {String} rtspUrl
         * @param {String} locationName
         * @param {Event|null} clickEvent  <-- dipakai untuk posisi popup
         */
        openStream(cctvId, cctvName, hlsUrl, rtspUrl, locationName, clickEvent = null) {
            // cleanup dulu
            this.closePopup();

            // set data
            this.popupTitle = cctvName;
            this.popupLocation = locationName || '';
            this.hlsUrl = hlsUrl || '';
            this.rtspUrl = rtspUrl || '';
            this.hasHlsStream = !!hlsUrl;
            this.hasRtspStream = !!rtspUrl && !hlsUrl; // tampilkan info RTSP kalau tak ada HLS
            this.isLoading = !!hlsUrl;
            this.errorMessage = '';
            this.isMuted = false;

            // hitung ukuran popup (perkiraan)
            const popupWidth = Math.min(800, window.innerWidth - 32);
            const popupHeight = Math.min(520, window.innerHeight - 32);

            // tentukan posisi awal berdasarkan elemen yang diklik (atau fallback ke viewport tengah atas)
            let x, y;
            if (clickEvent?.currentTarget) {
                const rect = clickEvent.currentTarget.getBoundingClientRect();
                x = rect.left + rect.width / 2 - popupWidth / 2;
                y = rect.top + 16; // sedikit di bawah tombol
            } else {
                x = window.innerWidth / 2 - popupWidth / 2;
                y = 120; // 120px dari atas viewport
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

        // --- video.js ---
        initVideoPlayer() {
            // dispose jika ada sebelumnya
            if (this.player) {
                try { this.player.dispose(); } catch (_) {}
                this.player = null;
            }

            const el = this.$refs.videoPlayer;
            if (!el || typeof videojs === 'undefined') {
                this.showErrorMessage('Video.js tidak tersedia');
                return;
            }

            // pastikan kosong dulu
            el.removeAttribute('src');

            this.player = videojs(el, {
                controls: true,
                autoplay: true,
                preload: 'auto',
                fluid: true,
                responsive: true,
                html5: { hls: { overrideNative: true } }
            });

            // set sumber
            this.player.src({ src: this.hlsUrl, type: 'application/x-mpegURL' });

            // events
            this.player.on('loadstart', () => { this.isLoading = true; });
            this.player.on('loadedmetadata', () => { this.isLoading = false; });
            this.player.on('playing', () => { this.isLoading = false; });
            this.player.on('error', () => {
                const err = this.player?.error();
                const code = err?.code;
                let msg = err?.message || 'Terjadi kesalahan saat memuat video';
                if (code === 4) msg = 'Format/URL tidak valid atau tidak didukung';
                if (code === 1) msg = 'Video tidak dapat dimuat, cek koneksi internet';
                if (code === 2) msg = 'Jaringan bermasalah, coba lagi';
                if (code === 3) msg = 'Video rusak atau tidak dapat diputar';
                this.showErrorMessage(msg);
            });
        },

        // --- controls overlays ---
        togglePlayPause() {
            if (!this.player) return;
            if (this.player.paused()) this.player.play();
            else this.player.pause();
        },
        toggleMute() {
            if (!this.player) return;
            const now = !this.player.muted();
            this.player.muted(now);
            this.isMuted = now;
        },
        toggleFullscreen() {
            if (!this.player) return;
            if (this.player.isFullscreen()) this.player.exitFullscreen();
            else this.player.requestFullscreen();
        },

        // --- error ---
        showErrorMessage(message) {
            this.isLoading = false;
            this.errorMessage = message;
        },

        // --- close & cleanup ---
        closePopup() {
            this.showPopup = false;
            this.errorMessage = '';
            this.isLoading = false;
            if (this.player) {
                try { this.player.dispose(); } catch (_) {}
                this.player = null;
            }
        },

        // --- dragging ---
        startDrag(event) {
            this.isDragging = true;
            const { x, y } = this.getEventClient(event);
            this.dragOffset = {
                x: x - this.popupPosition.x,
                y: y - this.popupPosition.y
            };

            // bind listeners pada document agar drag tetap jalan meski cursor keluar header
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
