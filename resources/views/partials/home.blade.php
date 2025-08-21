<div class="max-w-7xl mx-auto px-4 py-6"
     x-data="{
        active: 0,
        direction: 'next',
        slides: [
            {
                image: '/images/slider/slide1.png',
                title: 'TMC (Traffic Management Center)',
                text: 'Pusat pengaturan dan pengawasan lalu lintas Dishub Balikpapan. Menggunakan ATCS, CCTV, dan pengeras suara untuk optimalkan kinerja jaringan jalan. Masyarakat dapat memantau real-time lewat aplikasi ATCS TMC di Playstore.'
            },
            {
                image: '/images/slider/slide2.png',
                title: 'MATA PERHUBUNGAN',
                text: 'Sistem pengelolaan data Andalalin Dishub Balikpapan. Bagian dari SI-MAP untuk mengelola data lalu lintas, mendukung inovasi Digital/Smart City dan transparansi layanan publik.'
            },
            {
                image: '/images/slider/slide3.png',
                title: 'Integrasi Sistem: SI-PKB, SI-MAU, SI-WAS',
                text: 'Pengelolaan transportasi digital: SI-MAP untuk data lalu lintas, SI-MAU untuk angkutan umum, SI-PKB untuk uji KIR. Bagian dari transformasi Dishub menuju Smart City.'
            }
        ],
        start() {
            setInterval(() => {
                this.next();
            }, 12000);
        },
        next() {
            this.direction = 'next';
            this.active = (this.active + 1) % this.slides.length;
        },
        prev() {
            this.direction = 'prev';
            this.active = (this.active - 1 + this.slides.length) % this.slides.length;
        }
     }"
     x-init="start()">

    <div class="relative w-full overflow-hidden rounded-lg shadow-lg h-[500px]">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="index === active" 
                x-transition:enter="transform transition ease-in-out duration-700"
                x-transition:enter-start="direction === 'next' ? 'translate-x-full' : '-translate-x-full'"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="direction === 'next' ? '-translate-x-full' : 'translate-x-full'"
                class="absolute inset-0">

                <!-- Background Image -->
                <img :src="slide.image" alt="" class="w-full h-full object-cover">

                <!-- Text Overlay -->
                <div class="absolute inset-0 bg-black/50 flex flex-col justify-center px-8 md:px-16 text-white">
                    <h2 class="text-2xl md:text-4xl font-bold mb-4" x-text="slide.title"></h2>
                    <p class="text-sm md:text-lg max-w-3xl leading-relaxed" x-text="slide.text"></p>
                </div>
            </div>
        </template>

        <!-- Prev Button -->
        <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-3 rounded-full z-10">
            &#10094;
        </button>

        <!-- Next Button -->
        <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-3 rounded-full z-10">
            &#10095;
        </button>

        <!-- Pagination Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-3 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="active = index; direction = index > active ? 'next' : 'prev'"
                    :class="index === active ? 'bg-yellow-400' : 'bg-gray-300'"
                    class="w-4 h-4 rounded-full transition-colors duration-300"></button>
            </template>
        </div>
    </div>
</div>
