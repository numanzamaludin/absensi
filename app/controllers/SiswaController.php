<?php
require_once __DIR__ . '/../models/SiswaModel.php';

class SiswaController
{
    private $model;

    public function __construct()
    {
        $this->model = new SiswaModel();
    }

    // public function index()
    // {
    //     $data = $this->model->getAll();
    //     $kelasList = $this->model->getAllKelas(); // ← Tambahkan ini
    //     include __DIR__ . '/../views/siswa/index.php';
    // }



    public function index()
    {
        $filterKelas = $_GET['filter_kelas'] ?? null;

        $kelasList = $this->model->getAllKelas();

        if ($filterKelas) {
            $data = $this->model->getByKelas($filterKelas);
        } else {
            $data = $this->model->getAll();
        }

        include __DIR__ . '/../views/siswa/index.php';
    }





    public function tambah()
    {
        $kelasList = $this->model->getAllKelas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=siswa_index");
            exit;
        }

        include __DIR__ . '/../views/siswa/tambah.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID siswa tidak ditemukan.');

        $siswa = $this->model->getById($id);
        $kelasList = $this->model->getAllKelas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=siswa_index");
            exit;
        }

        include __DIR__ . '/../views/siswa/edit.php';
    }

    public function hapus()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=siswa_index");
        exit;
    }





    public function ajaxRiwayatAbsensi()
    {
        if (!isset($_SESSION['user']['id_siswa'])) {
            echo "<p style='color:red;'>Sesi siswa tidak ditemukan.</p>";
            return;
        }

        $id_siswa = $_SESSION['user']['id_siswa'];
        $tanggal  = $_GET['tanggal'] ?? date('j');
        $bulan    = $_GET['bulan'] ?? date('n');
        $tahun    = $_GET['tahun'] ?? date('Y');

        $tglLengkap = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);

        require_once __DIR__ . '/../models/AbsensiModel.php';
        $model = new AbsensiModel();
        $riwayat = $model->getAbsensiByTanggal($id_siswa, $tglLengkap);

        if (empty($riwayat)) {
            echo "<p><em>Tidak ada data absensi pada $tglLengkap.</em></p>";
            return;
        }

        echo '<table border="1" cellpadding="6">';
        echo '<thead><tr><th>Tanggal</th><th>Mata Pelajaran</th><th>Guru</th><th>Status</th><th>Keterangan</th></tr></thead><tbody>';
        foreach ($riwayat as $row) {
            echo "<tr>
            <td>{$row['tanggal']}</td>
            <td>{$row['nama_mapel']}</td>
            <td>{$row['nama_guru']}</td>
            <td>" . ucfirst($row['status_kehadiran']) . "</td>
            <td>{$row['keterangan']}</td>
        </tr>";
        }
        echo '</tbody></table>';
    }





    public function bulkUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = $_POST['selected_ids'] ?? [];
            $kelasBaru = $_POST['kelas_baru'] ?? null;

            if (!empty($ids) && $kelasBaru) {
                $this->model->updateKelasBulk($ids, $kelasBaru);
            }
        }

        header("Location: ?page=siswa_index");
        exit;
    }
}
