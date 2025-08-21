<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder {
    public function run() {
        $locations = [
            // Balikpapan Utara
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Rapak', 'latitude' => -1.241808, 'longitude' => 116.835321],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Wika', 'latitude' => -1.231539, 'longitude' => 116.875224],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Batu Ampar', 'latitude' => -1.21453, 'longitude' => 116.857662],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Patimura 1', 'latitude' => -1.217, 'longitude' => 116.854045],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Patimura 2', 'latitude' => -1.224096, 'longitude' => 116.866686],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Perumnas', 'latitude' => -1.223016, 'longitude' => 116.846165],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Indrakila', 'latitude' => -1.23494, 'longitude' => 116.839705],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'Tanjakan Mazda', 'latitude' => -1.22013, 'longitude' => 116.861562],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Kariangau', 'latitude' => -1.211932, 'longitude' => 116.862603],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'Global', 'latitude' => -1.234394, 'longitude' => 116.875089], // Disesuaikan dari 'Global Fix 1'
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Grand City', 'latitude' => -1.228144, 'longitude' => 116.871302],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Pasar Buton', 'latitude' => -1.214553, 'longitude' => 116.857643],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Straat 3', 'latitude' => -1.234901, 'longitude' => 116.839836],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Straat 1', 'latitude' => -1.239108, 'longitude' => 116.840013],
            ['kecamatan' => 'Balikpapan Utara', 'name' => 'SP Kampung Timur', 'latitude' => -1.236517, 'longitude' => 116.854856],

            // Balikpapan Timur
            ['kecamatan' => 'Balikpapan Timur', 'name' => 'Depan Stadion Batakan', 'latitude' => -1.238187, 'longitude' => 116.949704],

            // Balikpapan Tengah
            ['kecamatan' => 'Balikpapan Tengah', 'name' => 'SP Karang Jati', 'latitude' => -1.246007, 'longitude' => 116.834664],
            ['kecamatan' => 'Balikpapan Tengah', 'name' => 'SP Puskib', 'latitude' => -1.259266, 'longitude' => 116.839467],

            // Balikpapan Selatan
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Korpri', 'latitude' => -1.242126, 'longitude' => 116.888994],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Balikpapan Baru', 'latitude' => -1.240234, 'longitude' => 116.873526],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Lab Coal', 'latitude' => -1.25947, 'longitude' => 116.86686],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Tugu KB', 'latitude' => -1.257537, 'longitude' => 116.904118],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'KTL 1 Ruhui Rahayu', 'latitude' => -1.242151, 'longitude' => 116.885473],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'KTL 2 Ruhui Rahayu', 'latitude' => -1.242158, 'longitude' => 116.883553],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'KTL 3 Ruhui Rahayu', 'latitude' => -1.242154, 'longitude' => 116.879928],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Beller', 'latitude' => -1.260491, 'longitude' => 116.862615],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'SP Kargo Bandara', 'latitude' => -1.260158, 'longitude' => 116.896998], // Diperbaiki lat menjadi negatif
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'Depan Pasar Sepinggan', 'latitude' => -1.258226, 'longitude' => 116.907212],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'Depan AURI', 'latitude' => -1.259734, 'longitude' => 116.915576],
            ['kecamatan' => 'Balikpapan Selatan', 'name' => 'Perum Depan Regency', 'latitude' => -1.230838, 'longitude' => 116.888211],

            // Balikpapan Kota
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP Plaza', 'latitude' => -1.276957, 'longitude' => 116.837963],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP Markoni', 'latitude' => -1.275208, 'longitude' => 116.846471],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP Le Grandeur', 'latitude' => -1.272907, 'longitude' => 116.851481],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP Damai', 'latitude' => -1.269358, 'longitude' => 116.856751],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP G. Pasir', 'latitude' => -1.26718, 'longitude' => 116.836938],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP G. Malang', 'latitude' => -1.26232, 'longitude' => 116.839485],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'SP Imigrasi', 'latitude' => -1.277922, 'longitude' => 116.824933],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'KTL 1 Sudirman', 'latitude' => -1.277072, 'longitude' => 116.836703],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'KTL 2 Sudirman', 'latitude' => -1.277175, 'longitude' => 116.833376],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'KTL 3 Sudirman', 'latitude' => -1.277274, 'longitude' => 116.829819],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'KTL 4 Sudirman', 'latitude' => -1.27744, 'longitude' => 116.827605],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'KTL Depan DPRD', 'latitude' => -1.277428, 'longitude' => 116.828108],
            ['kecamatan' => 'Balikpapan Kota', 'name' => 'Tugu Jam Klandasan', 'latitude' => -1.277256, 'longitude' => 116.828651],

            // Balikpapan Barat
            ['kecamatan' => 'Balikpapan Barat', 'name' => 'SP Indrakila', 'latitude' => -1.242197, 'longitude' => 116.828414],
            ['kecamatan' => 'Balikpapan Barat', 'name' => 'SP Kebun Sayur', 'latitude' => -1.234728, 'longitude' => 116.822984],
            ['kecamatan' => 'Balikpapan Barat', 'name' => 'SP Pertamina', 'latitude' => -1.242055, 'longitude' => 116.831699],
            ['kecamatan' => 'Balikpapan Barat', 'name' => 'Karang Anyar PTZ', 'latitude' => -1.240509, 'longitude' => 116.828159],
        ];

        foreach ($locations as $l) {
            Location::create($l);
        }
    }
}