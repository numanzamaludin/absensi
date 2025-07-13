<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/GuruMapelModel.php';
require_once __DIR__ . '/../models/WaliKelasModel.php';
require_once __DIR__ . '/../models/KelasModel.php';
require_once __DIR__ . '/../models/RekapModel.php';

class RekapController
{
    private $model;

    public function __construct()
    {
        $this->model = new RekapModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Anda harus login sebagai guru.";
            exit;
        }

        $id_guru = $_SESSION['user']['id_guru'] ?? $_SESSION['user']['id'];
        $bulan   = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('m');
        $tahun   = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

        $guruMapelModel = new GuruMapelModel();
        $waliKelasModel = new WaliKelasModel();
        $kelasModel     = new KelasModel();
        $rekapModel     = new RekapModel();

        $kelasMapel = $guruMapelModel->getKelasByGuru($id_guru);
        $kelasWali  = $waliKelasModel->getKelasByGuru($id_guru);

        $kelasList = [];
        foreach (array_merge($kelasMapel, $kelasWali) as $kelas) {
            $kelasList[$kelas['id_kelas']] = $kelas['nama_kelas'];
        }

        $rekapData = [];
        foreach ($kelasList as $id_kelas => $nama_kelas) {
            $data = $rekapModel->getRekapBulananPerMapel($id_kelas, $bulan, $tahun);
            $rekapData[] = [
                'nama_kelas' => $nama_kelas,
                'data'       => $data
            ];
        }

        require_once __DIR__ . '/../views/rekap/index.php';
    }

    public function rekapBulananExcelStyle()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];

        // Ambil bulan dan tahun dari dropdown (GET)
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

        // Ambil data wali kelas
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("
        SELECT wk.id_kelas, k.nama_kelas, g.nama_guru
        FROM wali_kelas wk
        JOIN kelas k ON wk.id_kelas = k.id_kelas
        JOIN guru g ON wk.id_guru = g.id_guru
        WHERE wk.id_guru = ?
    ");
        $stmt->execute([$id_guru]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$kelas) {
            echo "Anda belum ditetapkan sebagai wali kelas.";
            return;
        }

        $id_kelas    = $kelas['id_kelas'];
        $nama_kelas  = $kelas['nama_kelas'];
        $wali_kelas  = $kelas['nama_guru'];

        // Ambil data absensi per siswa
        $model = new RekapModel();
        $siswaList = $model->getRekapHarianPerSiswa($id_kelas, $bulan, $tahun);

        require __DIR__ . '/../views/wali_kelas/rekap_excel_style.php';
    }



    public function rekapKehadiranHarian()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];

        $tanggal = $_GET['tanggal'] ?? date('j');
        $bulan   = $_GET['bulan'] ?? date('n');
        $tahun   = $_GET['tahun'] ?? date('Y');

        $tanggalLengkap = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);

        $data = $this->model->getKehadiranHarianByWali($id_guru, $tanggalLengkap);

        $kelas = '-';
        $wali  = '-';

        if (!empty($data)) {
            $kelas = $data[0]['nama_kelas'] ?? '-';
            $stmt = (new Database())->getConnection()->prepare("
                SELECT g.nama_guru FROM wali_kelas wk
                JOIN guru g ON g.id_guru = wk.id_guru
                WHERE wk.id_kelas = ?
                LIMIT 1
            ");
            $stmt->execute([$data[0]['id_kelas'] ?? 0]);
            $waliRow = $stmt->fetch();
            $wali = $waliRow['nama_guru'] ?? 'Tidak diketahui';
        }

        require __DIR__ . '/../views/wali_kelas/rekap_kehadiran_harian_excel_style.php';
    }



    public function ajaxRekapBulananExcel()
    {
        $id_guru = $_SESSION['user']['id'] ?? null;

        if (!$id_guru) {
            echo "Tidak ada akses.";
            return;
        }

        $bulan = $_GET['bulan'] ?? date('n');
        $tahun = $_GET['tahun'] ?? date('Y');

        // Ambil kelas wali
        $stmt = (new Database())->getConnection()->prepare("
        SELECT wk.id_kelas, k.nama_kelas, g.nama_guru
        FROM wali_kelas wk
        JOIN kelas k ON wk.id_kelas = k.id_kelas
        JOIN guru g ON wk.id_guru = g.id_guru
        WHERE wk.id_guru = ?
    ");
        $stmt->execute([$id_guru]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$kelas) {
            echo "<p>Anda belum ditetapkan sebagai wali kelas.</p>";
            return;
        }

        $id_kelas = $kelas['id_kelas'];
        $model = new RekapModel();
        $siswaList = $model->getRekapHarianPerSiswa($id_kelas, $bulan, $tahun);

        // Variabel yang digunakan di _partial_table
        include __DIR__ . '/../views/wali_kelas/_partial_table.php';
    }


    public function detailRekapSiswa()
    {
        $id_kelas = $_GET['id_kelas'] ?? null;
        $id_mapel = $_GET['id_mapel'] ?? null;
        $bulan    = $_GET['bulan'] ?? date('n');
        $tahun    = $_GET['tahun'] ?? date('Y');

        if (!$id_kelas || !$id_mapel) {
            echo "Parameter tidak lengkap.";
            return;
        }

        $model = new RekapModel();
        $data = $model->getDetailAbsensiPerSiswa($id_kelas, $id_mapel, $bulan, $tahun);

        // Info kelas dan wali
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("
        SELECT k.nama_kelas, g.nama_guru AS wali_kelas, m.nama_mapel
        FROM kelas k
        JOIN wali_kelas w ON w.id_kelas = k.id_kelas
        JOIN guru g ON g.id_guru = w.id_guru
        JOIN guru_mapel gm ON gm.id_kelas = k.id_kelas
        JOIN mata_pelajaran m ON m.id_mapel = gm.id_mapel
        WHERE k.id_kelas = ? AND m.id_mapel = ?
        LIMIT 1
    ");
        $stmt->execute([$id_kelas, $id_mapel]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/guru_mapel/detail_rekap_siswa.php';
    }




    public function exportRekapBulanan($format)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $id_guru = $_SESSION['user']['id'];
        $bulan = $_GET['bulan'] ?? date('n');
        $tahun = $_GET['tahun'] ?? date('Y');

        // Ambil data kelas dan siswa
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("
        SELECT wk.id_kelas, k.nama_kelas, g.nama_guru
        FROM wali_kelas wk
        JOIN kelas k ON wk.id_kelas = k.id_kelas
        JOIN guru g ON wk.id_guru = g.id_guru
        WHERE wk.id_guru = ?
    ");
        $stmt->execute([$id_guru]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$kelas) {
            echo "Anda bukan wali kelas.";
            return;
        }

        $model = new RekapModel();
        $data = $model->getRekapHarianPerSiswa($kelas['id_kelas'], $bulan, $tahun);

        // 🔄 Ekspor sesuai format
        require_once __DIR__ . '/../exports/ExportHelper.php';
        $exporter = new ExportHelper();
        $exporter->export($data, $kelas, $bulan, $tahun, $format);
    }



    public function exportKehadiranHarian()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $format = $_GET['format'] ?? 'xls';
        $id_guru = $_SESSION['user']['id'];
        $tanggal = $_GET['tanggal'] ?? date('j');
        $bulan   = $_GET['bulan'] ?? date('n');
        $tahun   = $_GET['tahun'] ?? date('Y');

        $tanggalLengkap = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);

        $model = new RekapModel();
        $data = $model->getKehadiranHarianByWali($id_guru, $tanggalLengkap);

        // Ambil info kelas & wali
        $kelas = $data[0]['nama_kelas'] ?? '-';
        $wali  = '-';
        if (!empty($data)) {
            $stmt = (new Database())->getConnection()->prepare("
            SELECT g.nama_guru FROM wali_kelas wk
            JOIN guru g ON g.id_guru = wk.id_guru
            WHERE wk.id_kelas = ?
            LIMIT 1
        ");
            $stmt->execute([$data[0]['id_kelas'] ?? 0]);
            $row = $stmt->fetch();
            $wali = $row['nama_guru'] ?? '-';
        }

        require_once __DIR__ . '/../exports/ExportHelper.php';
        $exporter = new ExportHelper();
        $exporter->exportHarian($data, $kelas, $wali, $tanggalLengkap, $format);
    }


    public function exportDetailMapel()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
            echo "Akses ditolak.";
            exit;
        }

        $format   = $_GET['format'] ?? 'xls';
        $id_kelas = $_GET['id_kelas'] ?? null;
        $id_mapel = $_GET['id_mapel'] ?? null;
        $bulan    = $_GET['bulan'] ?? date('n');
        $tahun    = $_GET['tahun'] ?? date('Y');

        if (!$id_kelas || !$id_mapel) {
            echo "Parameter tidak lengkap.";
            return;
        }

        $model = new RekapModel();
        $data  = $model->getDetailAbsensiBulananPerMapel($id_kelas, $id_mapel, $bulan, $tahun);
        $info  = $model->getInfoMapelKelas($id_kelas, $id_mapel);

        require_once __DIR__ . '/../exports/ExportHelper.php';
        $exporter = new ExportHelper();
        $exporter->exportDetailMapel($data, $info, $bulan, $tahun, $format);
    }




    // RekapController.php
    public function ajaxRekapKehadiranHarian()
    {
        $id_guru = $_SESSION['user']['id'] ?? null;
        if (!$id_guru) {
            http_response_code(403);
            echo "Akses ditolak";
            return;
        }

        $tanggal = $_GET['tanggal'] ?? date('j');
        $bulan   = $_GET['bulan'] ?? date('n');
        $tahun   = $_GET['tahun'] ?? date('Y');

        $tanggalLengkap = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);

        $this->model = new RekapModel();
        $data = $this->model->getKehadiranHarianByWali($id_guru, $tanggalLengkap);

        // info kelas & wali
        $kelas = '-';
        $wali = '-';
        if (!empty($data)) {
            $kelas = $data[0]['nama_kelas'];
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("SELECT g.nama_guru FROM wali_kelas wk JOIN guru g ON g.id_guru = wk.id_guru WHERE wk.id_kelas = ? LIMIT 1");
            $stmt->execute([$data[0]['id_kelas'] ?? 0]);
            $waliRow = $stmt->fetch();
            $wali = $waliRow['nama_guru'] ?? '-';
        }

        // Kirim view partial
        $tanggalDipilih = $tanggal;
        $bulanDipilih = $bulan;
        $tahunDipilih = $tahun;

        include __DIR__ . '/../views/wali_kelas/_partial_rekap_harian_table.php';
    }
}
