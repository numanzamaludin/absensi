<?php
require_once __DIR__ . '/../models/AbsensiModel.php';

class AbsensiController
{
    private $model;

    public function __construct()
    {
        $this->model = new AbsensiModel();
    }

    public function form()
    {
        $id_kelas = $_GET['kelas'] ?? null;
        $id_mapel = $_GET['mapel'] ?? null;
        $id_guru = $_SESSION['user']['id'];
        $guruMapel = $this->model->getGuruMapel($id_mapel, $id_kelas, $id_guru);
        $id_guru_mapel = $guruMapel['id_guru_mapel'] ?? null;

        if ($id_kelas && $id_mapel) {
            $siswa = $this->model->getSiswaByKelas($id_kelas);
            $kelasTerpilih = $this->model->getKelasById($id_kelas);
            $mapel = $this->model->getMapelById($id_mapel);

            if (!$id_guru_mapel) {
                echo "<script>
                    alert('Tidak ditemukan relasi guru-mapel-kelas.');
                    window.history.back();
                </script>";
                return;
            }


            // ✅ Cek Jadwal Hari & Jam Sekarang
            $hariMap = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            ];
            $hariSekarang = $hariMap[date('l')];
            $jamSekarang = date('H:i:s');

            $db = (new Database())->getConnection();
            $stmt = $db->prepare("
            SELECT * FROM jadwal 
            WHERE id_guru_mapel = :id_guru_mapel 
              AND hari = :hari 
              AND :jam BETWEEN jam_mulai AND jam_selesai
        ");
            $stmt->execute([
                ':id_guru_mapel' => $id_guru_mapel,
                ':hari' => $hariSekarang,
                ':jam' => $jamSekarang,
            ]);
            $jadwalAktif = $stmt->fetch();

            if (!$jadwalAktif) {
                echo "<script>
                    alert('Anda tidak memiliki jadwal mengajar saat ini (hari ini: $hariSekarang, jam: $jamSekarang).');
                    window.history.back();
                </script>";
                return;
            }


            // ✅ Tampilkan form absensi
            require __DIR__ . '/../views/absensi/form.php';
        } else {
            echo "<p style='color:red;'>Parameter 'kelas' dan 'mapel' wajib ada!</p>";
        }
    }


    public function simpan()
    {
        $id_guru_mapel = $_POST['id_guru_mapel'];
        $id_kelas = $_POST['id_kelas'];
        $tanggal = date('Y-m-d');
        $id_wali_kelas = $_SESSION['user']['id'];
        $keterangan = $_POST['keterangan'] ?? [];

        // ✅ CEK: Apakah absensi hari ini sudah ada
        if ($this->model->absensiSudahAda($id_guru_mapel, $id_kelas, $tanggal)) {
            echo "<script>alert('Absensi untuk hari ini sudah ada.'); window.location.href='?page=dashboard';</script>";
            exit;
        }

        // ⬇️ INSERT absensi jika belum ada
        $idAbsensi = $this->model->insertAbsensi($id_guru_mapel, $id_kelas, $tanggal, $id_wali_kelas, $keterangan);

        foreach ($_POST['absensi'] as $id_siswa => $status) {
            $ket = $keterangan[$id_siswa] ?? null;
            $this->model->insertAbsensiDetail($idAbsensi, $id_siswa, $status, $ket);
        }

        header("Location: ?page=dashboard");
        exit;
    }


    public function persetujuan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_absensi'] ?? null;
            $aksi = $_POST['aksi'] ?? null;

            if ($id && in_array($aksi, ['setuju', 'tolak'])) {
                $status = $aksi === 'setuju' ? 'disetujui' : 'ditolak';
                $this->model->updateStatusWaliKelas($id, $status);
                if ($status === 'disetujui') {
                    $this->model->updateStatusPengiriman($id);
                }

                header("Location: ?page=dashboard");
                exit;
            }
        }

        echo "Permintaan tidak valid.";
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID Absensi tidak ditemukan.";
            return;
        }

        // Ambil koneksi PDO dari class Database
        $db = (new Database())->getConnection();

        // Ambil data absensi
        $stmt = $db->prepare("SELECT a.*, k.nama_kelas, mp.nama_mapel FROM absensi a 
                          JOIN kelas k ON k.id_kelas = a.id_kelas 
                          JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
                          JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
                          WHERE a.id_absensi = ?");
        $stmt->execute([$id]);
        $absensi = $stmt->fetch();

        // Ambil data siswa yang terkait dengan absensi tersebut
        $stmt = $db->prepare("SELECT sa.*, s.nama_siswa FROM absensi_detail sa 
                      JOIN siswa s ON s.id_siswa = sa.id_siswa 
                      WHERE sa.id_absensi = ?");

        $stmt->execute([$id]);
        $siswa = $stmt->fetchAll();

        include __DIR__ . '/../views/absensi/absensi_detail.php';
    }

    public function dashboardGuru()
    {
        $id_guru = $_SESSION['user']['id'];
        $absensiPending = $this->model->getAbsensiPendingByGuru($id_guru);
        $absensiDitolak = $this->model->getAbsensiDitolakByGuru($id_guru);


        require __DIR__ . '/../views/dashboard/guru.php';
    }


    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID Absensi tidak ditemukan.";
            return;
        }

        $db = (new Database())->getConnection();

        // Ambil data absensi
        $stmt = $db->prepare("SELECT * FROM absensi WHERE id_absensi = ?");
        $stmt->execute([$id]);
        $absensi = $stmt->fetch();

        if (!$absensi) {
            echo "Data absensi tidak ditemukan.";
            return;
        }

        // Ambil data detail absensi (siswa dan kehadiran mereka)
        $stmt = $db->prepare("SELECT ad.*, s.nama_siswa 
                          FROM absensi_detail ad 
                          JOIN siswa s ON s.id_siswa = ad.id_siswa 
                          WHERE ad.id_absensi = ?");
        $stmt->execute([$id]);
        $absensiDetail = $stmt->fetchAll();




        include __DIR__ . '/../views/absensi/edit_absensi.php';
    }



    public function prosesEdit()
    {
        $id_absensi = $_POST['id_absensi'] ?? null;
        // $tanggal = $_POST['tanggal'] ?? null;
        $keterangan = $_POST['keterangan'] ?? '';
        $keterangan_siswa_all = $_POST['keterangan'] ?? [];

        $kehadiran = $_POST['kehadiran'] ?? [];

        if (!$id_absensi) {
            echo "ID absensi tidak tersedia.";
            return;
        }

        $db = (new Database())->getConnection();

        // Update absensi utama
        $stmt = $db->prepare("UPDATE absensi SET status_wali_kelas = 'pending' WHERE id_absensi = ?");
        $stmt->execute([$id_absensi]);



        // Update detail kehadiran siswa
        foreach ($kehadiran as $id_siswa => $status_kehadiran) {
            $keterangan_siswa = $keterangan_siswa_all[$id_siswa] ?? null;

            $stmt = $db->prepare("
        UPDATE absensi_detail 
        SET status_kehadiran = :status_kehadiran, keterangan = :keterangan 
        WHERE id_absensi = :id_absensi AND id_siswa = :id_siswa
    ");
            $stmt->execute([
                'status_kehadiran' => $status_kehadiran,
                'keterangan' => $keterangan_siswa,
                'id_absensi' => $id_absensi,
                'id_siswa' => $id_siswa
            ]);
        }



        header("Location: ?page=dashboard");
        exit;
    }

    public function dashboardSiswa()
    {
        $id_siswa = $_SESSION['user']['id'];
        $absensiHariIni = $this->model->getAbsensiHariIni($id_siswa);

        require __DIR__ . '/../views/dashboard/siswa.php';
    }


    public function rekapBulananGuru()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $id_guru = $_SESSION['user']['id_guru'] ?? $_SESSION['user']['id'];
        $bulan   = $_POST['bulan'] ?? date('m');
        $tahun   = $_POST['tahun'] ?? date('Y');

        $rekap = $this->model->getRekapBulananGuruMapel($id_guru, $bulan, $tahun);

        require __DIR__ . '/../views/guru_mapel/rekap_bulanan_guru.php';
    }


    public function riwayatGuru()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Anda harus login sebagai guru.";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];
        $absensiModel = new AbsensiModel();
        $riwayat = $absensiModel->getRiwayatLengkapGuru($id_guru);

        require_once __DIR__ . '/../views/absensi/riwayat_siswa.php'; // atau riwayat_guru.php
    }



    // public function rekapKehadiranHarian()
    // {
    //     if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
    //         echo "Akses ditolak";
    //         exit;
    //     }

    //     $id_guru = $_SESSION['user']['id'];
    //     $data = $this->model->getKehadiranHarianByWali($id_guru);

    //     require __DIR__ . '/../views/wali_kelas/rekap_kehadiran_harian.php';
    // }



    public function rekapBulananWali()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];
        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');

        $data = $this->model->getRekapBulananByWali($id_guru, $bulan, $tahun);

        require __DIR__ . '/../views/wali_kelas/rekap_bulanan_wali.php';
    }


    public function rekapKehadiranHarian()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];

        $data = $this->model->getKehadiranHarianByWali($id_guru);

        $kelas = '-';
        $wali = '-';

        if (!empty($data)) {
            $id_kelas = $data[0]['id_kelas'] ?? null;
            $kelas = $data[0]['nama_kelas'] ?? '-';

            if ($id_kelas) {
                // Ambil nama wali kelas dari tabel wali_kelas → guru
                $db = (new Database())->getConnection();
                $stmt = $db->prepare("
                SELECT g.nama_guru
                FROM wali_kelas wk
                JOIN guru g ON g.id_guru = wk.id_guru
                WHERE wk.id_kelas = ?
                LIMIT 1
            ");
                $stmt->execute([$id_kelas]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $wali = $row['nama_guru'];
                }
            }
        }

        // Kirim ke view
        require __DIR__ . '/../views/wali_kelas/rekap_kehadiran_harian_excel_style.php';
    }









    public function absenGuru()
    {
        header('Content-Type: application/json');

        // Ambil data dari frontend (pastikan POST dan JSON)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['latitude'], $data['longitude'])) {
            echo json_encode(['message' => 'Data lokasi tidak lengkap']);
            return;
        }

        $lat = $data['latitude'];
        $lng = $data['longitude'];

        // Ambil data guru yang sedang login
        require_once __DIR__ . '/../helpers/AuthHelper.php';
        // $user = AuthHelper::getLoggedInUser(); ❌

        $user = current_user(); // ✅ Pakai fungsi global dari file helper


        if (!$user || !isset($user['id_guru'])) {
            echo json_encode(['message' => 'Anda belum login sebagai guru']);
            return;
        }

        $id_guru = $user['id_guru'];

        // Titik koordinat sekolah (pastikan sesuai)
        $lat_sekolah = -6.945076739192162;
        $lng_sekolah = 107.82877954425605;

        // Hitung jarak lokasi guru dari sekolah
        $jarak = $this->hitungJarak($lat, $lng, $lat_sekolah, $lng_sekolah);
        if ($jarak > 0.1) { // 0.1 km = 100 meter
            echo json_encode(['message' => 'Anda berada di luar lingkungan sekolah']);
            return;
        }

        // Cek jadwal aktif
        require_once __DIR__ . '/../models/JadwalModel.php';
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->getJadwalAktifSekarang($id_guru);

        if (!$jadwal || !isset($jadwal['id_jadwal'])) {
            echo json_encode(['message' => 'Tidak ada jadwal aktif saat ini']);
            return;
        }

        $id_jadwal = $jadwal['id_jadwal'];

        // Cek apakah sudah absen
        require_once __DIR__ . '/../models/AbsensiModel.php';
        $absensiModel = new AbsensiModel();
        $sudahAbsen = $absensiModel->cekSudahAbsenGuru($id_guru, $id_jadwal);

        if ($sudahAbsen) {
            echo json_encode(['message' => 'Anda sudah absen untuk jadwal ini']);
            return;
        }

        // Simpan data absensi
        $lokasi = $lat . ',' . $lng;
        $absensiModel->simpanAbsenGuru($id_guru, $id_jadwal, $lokasi);

        echo json_encode(['message' => 'Absensi berhasil']);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return $miles * 1.609344; // dalam KM
    }






    public function riwayatHarianGuru()
    {
        $tanggal = $_GET['tanggal'] ?? date('Y-m-d');
        $idGuru = $_SESSION['user']['id_guru'];
        $riwayat = $this->model->getAbsensiHarianGuru($idGuru, $tanggal);

        require_once __DIR__ . '/../views/absensi/riwayat_harian_guru.php';
    }

    public function riwayatBulananGuru()
    {
        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');
        $idGuru = $_SESSION['user']['id_guru'];

        $riwayat = $this->model->getAbsensiBulananGuru($idGuru, $bulan, $tahun);


        require_once __DIR__ . '/../views/absensi/riwayat_bulanan_guru.php';
    }



    public function ajaxRiwayatBulananGuru()
    {
        require_once __DIR__ . '/../helpers/render_helper.php'; // ← HARUS sebelum renderTable dipanggil

        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');
        $idGuru = $_SESSION['user']['id_guru'];

        $riwayat = $this->model->getAbsensiBulananGuru($idGuru, $bulan, $tahun);

        if (!empty($riwayat)) {
            echo renderTable($riwayat);
        } else {
            echo "<p>Tidak ada data absensi untuk bulan ini.</p>";
        }
    }
}
