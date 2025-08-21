<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cctv;
use App\Models\Location;

class CctvSeeder extends Seeder {
    public function run() {
        $rows = [
            // Balikpapan Barat
            ['name'=>'SP Pertamina Fix 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.178/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Pertamina'],
            ['name'=>'SP Pertamina Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.177/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Pertamina'],
            ['name'=>'SP Pertamina Fix 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.176/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Pertamina'],
            ['name'=>'SP Pertamina','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.175/h264/ch1/sub/av_stream','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Pertamina'],
            ['name'=>'SP Kebun Sayur Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.167/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Kebun Sayur'],
            ['name'=>'SP Kebun Sayur Fix 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.166/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Kebun Sayur'],
            ['name'=>'SP Kebun Sayur','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.129/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Barat','location_name'=>'SP Kebun Sayur'],

            // Balikpapan Kota
            ['name'=>'SP Markoni Fix 2','rtsp_url'=>'rtsp://admin:Marktel123456@192.168.110.133/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Markoni'],
            ['name'=>'SP Imigrasi Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.180/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Imigrasi'],
            ['name'=>'SP Imigrasi','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.112/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Imigrasi'],
            ['name'=>'SP Gunung Pasir Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.179/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP G. Pasir'],
            ['name'=>'SP Gunung Pasir','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.105/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP G. Pasir'],
            ['name'=>'SP Gunung Malang Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.168/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP G. Malang'],
            ['name'=>'SP Gunung Malang','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.106/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP G. Malang'],
            ['name'=>'KTL Sudirman 4','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.122/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL 4 Sudirman'],
            ['name'=>'KTL Sudirman 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.121/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL 3 Sudirman'],
            ['name'=>'KTL Sudirman 2 Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.184/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL 2 Sudirman'],
            ['name'=>'KTL Sudirman 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.120/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL 2 Sudirman'],
            ['name'=>'KTL Sudirman 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.119/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL 1 Sudirman'],
            ['name'=>'KTL Depan DPRD','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.190/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'KTL Depan DPRD'],
            ['name'=>'Gn.Malang Arah PLTD','rtsp_url'=>'rtsp://admin:Marktel123456@192.168.110.127/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP G. Malang'],
            ['name'=>'CCTV Tugu Jam PTZ','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.64/h264/ch1/sub/av_stream','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'Tugu Jam Klandasan'],
            ['name'=>'CCTV Tugu Jam Fix 4','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.63/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'Tugu Jam Klandasan'],
            ['name'=>'CCTV Tugu Jam Fix 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.62/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'Tugu Jam Klandasan'],
            ['name'=>'CCTV Tugu Jam Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.61/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'Tugu Jam Klandasan'],
            ['name'=>'CCTV Tugu Jam Fix 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.60/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'Tugu Jam Klandasan'],
            ['name'=>'CCTV SP Plaza','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.101/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Plaza'],
            ['name'=>'CCTV SP Markoni','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.102/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Markoni'],
            ['name'=>'CCTV SP Le Grandeur','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.103/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Le Grandeur'],
            ['name'=>'CCTV SP Damai','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.104/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Damai'],
            ['name'=>'CCTV Plaza 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.169/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Plaza'],
            ['name'=>'CCTV Plaza 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.169/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Plaza'],
            ['name'=>'CCTV Markoni Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.158/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Markoni'],
            ['name'=>'CCTV Markoni','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.105/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Markoni'],
            ['name'=>'CCTV Damai Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.188/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Damai'],
            ['name'=>'CCTV Damai Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.160/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Kota','location_name'=>'SP Damai'],

            // Balikpapan Selatan
            ['name'=>'SP Lab Coal Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.185/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Lab Coal'],
            ['name'=>'SP Lab Coal','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.111/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Lab Coal'],
            ['name'=>'SP Kargo Bandara Kamera Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.199/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Kargo Bandara'],
            ['name'=>'SP Kargo Bandara','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.170/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Kargo Bandara'],
            ['name'=>'SP Beller Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.194/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Beller'],
            ['name'=>'SP Beller','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.193/h264/ch1/sub/av_stream','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Beller'],
            ['name'=>'Perum Regency Arah Korpri','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.141/Streaming/Channels/101','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Perum Depan Regency'],
            ['name'=>'Depan Regency Arah Polda','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.142/Streaming/Channels/101','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Perum Depan Regency'],
            ['name'=>'Depan Pasar Sepinggan Kamera Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.68/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Depan Pasar Sepinggan'],
            ['name'=>'Depan Pasar Sepinggan','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.171/Streaming/Channels/101','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Depan Pasar Sepinggan'],
            ['name'=>'Depan Bandara Arah Tugu KB','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.55/Streaming/Channels/101','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Tugu KB'],
            ['name'=>'Depan Bandara Arah SPBU','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.140/Streaming/Channels/101','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Tugu KB'],
            ['name'=>'Depan AURI Kamera PTZ','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.71/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Depan AURI'],
            ['name'=>'Depan AURI Kamera Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.70/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'Depan AURI'],
            ['name'=>'CCTV Tugu KB Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.183/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Tugu KB'],
            ['name'=>'CCTV Tugu KB Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.161/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Tugu KB'],
            ['name'=>'CCTV SP Tugu KB','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.114/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Tugu KB'],
            ['name'=>'CCTV SP Korpri','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.109/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Korpri'],
            ['name'=>'CCTV KTL Ruhui Rahayu 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.118/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'KTL 3 Ruhui Rahayu'],
            ['name'=>'CCTV KTL Ruhui Rahayu 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.117/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'KTL 2 Ruhui Rahayu'],
            ['name'=>'CCTV KTL Ruhui Rahayu 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.116/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'KTL 1 Ruhui Rahayu'],
            ['name'=>'CCTV Korpri 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.187/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Korpri'],
            ['name'=>'CCTV Korpri 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.157/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Korpri'],
            ['name'=>'CCTV Korpri 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.156/Streaming/channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Korpri'],
            ['name'=>'CCTV Balikpapan Baru Fix 4','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.153/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Balikpapan Baru'],
            ['name'=>'CCTV Balikpapan Baru Fix 3','rtsp_url'=>'rtsp://admin:Dishub123@192.168.110.152/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Balikpapan Baru'],
            ['name'=>'CCTV Balikpapan Baru Fix 2','rtsp_url'=>'rtsp://admin:Dishub123@192.168.110.151/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Balikpapan Baru'],
            ['name'=>'CCTV Balikpapan Baru Fix 1','rtsp_url'=>'rtsp://admin:Dishub123@192.168.110.150/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Balikpapan Baru'],
            ['name'=>'CCTV Balikpapan Baru','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.110/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Selatan','location_name'=>'SP Balikpapan Baru'],

            // Balikpapan Tengah
            ['name'=>'CCTV SP Puskib','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.115/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Tengah','location_name'=>'SP Puskib'],
            ['name'=>'CCTV SP Karang Jati','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.107/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Tengah','location_name'=>'SP Karang Jati'],

            // Balikpapan Timur
            ['name'=>'Depan Stadion Batakan Kamera Fix','rtsp_url'=>'rtsp://admin:Marktel123456@192.168.110.72/Streaming/Channels/101','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Timur','location_name'=>'Depan Stadion Batakan'],
            ['name'=>'Depan Stadion Batakan','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.73/Streaming/Channels/101','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Timur','location_name'=>'Depan Stadion Batakan'],

            // Balikpapan Utara
            ['name'=>'Tanjakan Mazda','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.130/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'Tanjakan Mazda'],
            ['name'=>'SP Wika Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.165/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Wika'],
            ['name'=>'SP Wika','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.124/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Wika'],
            ['name'=>'SP Straat 3 Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.135/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Straat 3'],
            ['name'=>'SP Straat 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.128/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Straat 3'],
            ['name'=>'SP Straat 1 Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.134/h264/ch4/main/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Straat 1'],
            ['name'=>'SP Straat 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.174/h264/ch1/sub/av_stream','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Straat 1'],
            ['name'=>'SP Perumnas','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.131/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Perumnas'],
            ['name'=>'SP Patimura RSKD Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.162/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Patimura 1'], // Asumsi matching ke SP Patimura 1 atau 2 berdasarkan nama
            ['name'=>'SP Patimura RSKD','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.123/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Patimura 1'],
            ['name'=>'SP Patimura Batu Ampar Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.197/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Patimura 2'],
            ['name'=>'SP Patimura Batu Ampar','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.126/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Patimura 2'],
            ['name'=>'SP Pasar Buton Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.196/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Pasar Buton'],
            ['name'=>'SP Pasar Buton PTZ','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.125/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Pasar Buton'],
            ['name'=>'SP Kariangau Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.189/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Kariangau'],
            ['name'=>'SP Kariangau','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.132/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Kariangau'],
            ['name'=>'SP Kampung Timur Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.198/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Kampung Timur'],
            ['name'=>'SP Kampung Timur','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.113/h264/ch1/sub/av_stream','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Kampung Timur'],
            ['name'=>'SP Grandcity Fix','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.65/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Grand City'],
            ['name'=>'SP Grandcity PTZ','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.191/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Grand City'],
            ['name'=>'SP Batu Ampar','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.125/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Batu Ampar'],
            ['name'=>'Global Fix 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.164/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'Global'],
            ['name'=>'Global Fix 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.163/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'Global'],
            ['name'=>'CCTV SP Rapak','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.108/Streaming/Channels/102','camera_type'=>'PTZ','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Rapak'],
            ['name'=>'CCTV Rapak 3','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.181/h264/ch1/sub/av_stream','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Rapak'],
            ['name'=>'CCTV Rapak 2','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.155/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Rapak'],
            ['name'=>'CCTV Rapak 1','rtsp_url'=>'rtsp://admin:Marktel12345@192.168.110.154/Streaming/Channels/102','camera_type'=>'Fix','status'=>'Active','kecamatan'=>'Balikpapan Utara','location_name'=>'SP Rapak'],
        ];

        foreach($rows as $index => $r) {
            $location = Location::where('kecamatan', $r['kecamatan'])->where('name', $r['location_name'])->first();
            if ($location) {
                // Generate sample HLS URL based on camera index
                $hlsUrl = "http://localhost:8080/hls/camera_" . ($index + 1) . ".m3u8";
                
                Cctv::create([
                    'name' => $r['name'],
                    'rtsp_url' => $r['rtsp_url'],
                    'hls_url' => $hlsUrl,
                    'camera_type' => $r['camera_type'],
                    'status' => $r['status'],
                    'location_id' => $location->id,
                ]);
            }
        }
    }
}