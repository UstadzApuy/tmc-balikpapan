<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Location;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Sample news data with professional announcements and location-specific details
        $newsData = [
            [
                'title' => 'Peringatan Cuaca Hujan',
                'content' => 'Kepada pengguna jalan, harap berhati-hati saat berkendara karena kondisi cuaca hujan di beberapa wilayah. Pastikan kendaraan dalam kondisi baik dan perhatikan keselamatan di jalan raya. Wilayah terdampak: ',
                'weather_condition' => 'hujan',
                'locations' => []
            ],
            [
                'title' => 'Informasi Aplikasi TMC Balikpapan',
                'content' => 'Selamat datang di Aplikasi Pemantauan CCTV Kota Balikpapan, yang disediakan oleh Dinas Perhubungan Kota Balikpapan. Aplikasi ini memungkinkan masyarakat untuk memantau kondisi lalu lintas secara langsung melalui CCTV yang terpasang di berbagai lokasi di Kota Balikpapan. Informasi ini berlaku untuk seluruh wilayah Kota Balikpapan.',
                'weather_condition' => 'info',
                'locations' => []
            ],
            [
                'title' => 'Peringatan Genangan Air',
                'content' => 'Telah terdeteksi genangan air di beberapa wilayah akibat curah hujan tinggi. Pengguna jalan diimbau untuk mencari rute alternatif atau menunda perjalanan hingga kondisi aman. Wilayah terdampak: ',
                'weather_condition' => 'banjir',
                'locations' => []
            ],
            [
                'title' => 'Informasi Kemacetan Lalu Lintas',
                'content' => 'Terjadi kemacetan ringan di beberapa ruas jalan akibat tingkat kepadatan lalu lintas yang meningkat. Pengguna jalan diharapkan bersabar dan mengikuti arahan petugas. Wilayah terdampak: ',
                'weather_condition' => 'kemacetan',
                'locations' => []
            ],
            [
                'title' => 'Peringatan Kepadatan Lalu Lintas',
                'content' => 'Kepadatan lalu lintas terjadi di beberapa titik akibat volume kendaraan yang tinggi. Pengguna jalan diminta untuk mengatur waktu perjalanan dengan bijak. Wilayah terdampak: ',
                'weather_condition' => 'kepadatan',
                'locations' => []
            ],
        ];

        foreach ($newsData as $data) {
            $news = News::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'weather_condition' => $data['weather_condition'],
                'is_active' => true,
            ]);

            // Attach locations if specified
            if (!empty($data['locations'])) {
                $locationIds = Location::whereIn('kecamatan', $data['locations'])->pluck('id');
                $news->locations()->attach($locationIds);
            }
        }
    }
}