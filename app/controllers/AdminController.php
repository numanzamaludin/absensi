
<?php
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/AbsensiModel.php';

class AdminController
{
    private $jadwalModel;
    private $absensiModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->absensiModel = new AbsensiModel();
    }

    public function absensiHarianGuru()
    {
        // 🔒 Cek apakah user bukan admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=unauthorized'); // Redirect ke halaman "tidak diizinkan"
            exit;
        }

        // --- Lanjut jika admin ---
        date_default_timezone_set('Asia/Jakarta');
        $hariIni = date('l'); // e.g., "Monday"
        $tanggal = date('Y-m-d');

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariDB = $hariMap[$hariIni];

        $jadwalHariIni = $this->jadwalModel->getJadwalByHari($hariDB);
        $absensiHariIni = $this->absensiModel->getAbsensiHariIniAdmin($tanggal);

        $waktuSekarang = date('H:i:s');
        $jadwalGabung = [];

        foreach ($jadwalHariIni as $jadwal) {
            // Lewati jadwal jika sudah lewat jam_selesai
            if ($jadwal['jam_selesai'] <= $waktuSekarang) {
                continue;
            }

            $sudahAbsen = false;
            foreach ($absensiHariIni as $absen) {
                if (
                    $absen['id_guru'] == $jadwal['id_guru']
                    && $absen['id_jadwal'] == $jadwal['id_jadwal']
                ) {
                    $sudahAbsen = true;
                    $jadwal['waktu_absen'] = $absen['waktu'];
                    break;
                }
            }
            $jadwal['sudah_absen'] = $sudahAbsen;
            $jadwalGabung[] = $jadwal;
        }

        include __DIR__ . '/../views/admin/absensi_harian.php';
    }



    public function loadAbsensiLive()
    {
        date_default_timezone_set('Asia/Jakarta');
        $hariIni = date('l');
        $tanggal = date('Y-m-d');

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariDB = $hariMap[$hariIni];

        $jadwalHariIni = $this->jadwalModel->getJadwalByHari($hariDB);
        $absensiHariIni = $this->absensiModel->getAbsensiHariIniAdmin($tanggal);

        $jadwalGabung = [];
        foreach ($jadwalHariIni as $jadwal) {
            // Filter hanya yang aktif
            $jamSelesai = strtotime($jadwal['jam_selesai']);
            if ($jamSelesai < time()) continue;

            $sudahAbsen = false;
            foreach ($absensiHariIni as $absen) {
                if ($absen['id_guru'] == $jadwal['id_guru'] && $absen['id_jadwal'] == $jadwal['id_jadwal']) {
                    $sudahAbsen = true;
                    $jadwal['waktu_absen'] = $absen['waktu'];
                    break;
                }
            }

            $jadwal['sudah_absen'] = $sudahAbsen;
            $jadwalGabung[] = $jadwal;
        }

        include __DIR__ . '/../views/admin/table_absensi_live.php';
    }
}
