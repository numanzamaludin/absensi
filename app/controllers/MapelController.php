<?php
require_once __DIR__ . '/../models/MapelModel.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class MapelController
{
    private $model;

    public function __construct()
    {
        $this->model = new MapelModel();
    }

    public function index()
    {
        $data = $this->model->getAll();
        $status = $_GET['status'] ?? null;
        include __DIR__ . '/../views/mapel/index.php';
    }

    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=mapel_index");
            exit;
        }
        include __DIR__ . '/../views/mapel/tambah.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("ID tidak ditemukan");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=mapel_index");
            exit;
        }

        $mapel = $this->model->getById($id);
        include __DIR__ . '/../views/mapel/edit.php';
    }

    public function hapus()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?page=mapel_index&status=id_invalid");
            exit;
        }

        // Cek apakah mapel masih digunakan di guru_mapel
        if ($this->model->isUsedInGuruMapel($id)) {
            header("Location: ?page=mapel_index&status=gagal_dihapus");
            exit;
        }

        $this->model->delete($id);
        header("Location: ?page=mapel_index&status=hapus_berhasil");
        exit;
    }

    public function importMapelProses()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_excel'])) {
            $file = $_FILES['file_excel']['tmp_name'];

            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            unset($sheet[0]); // hilangkan baris header

            $errors = [];

            foreach ($sheet as $row) {
                $nama_mapel = trim($row[0] ?? '');
                $kode_mapel = trim($row[1] ?? '');

                if (!$nama_mapel || !$kode_mapel) {
                    $errors[] = "Data kosong pada baris: $nama_mapel / $kode_mapel";
                    continue;
                }

                $this->model->insert([
                    'nama_mapel' => $nama_mapel,
                    'kode_mapel' => $kode_mapel
                ]);
            }

            if (!empty($errors)) {
                echo "<h4>Beberapa data gagal diimport:</h4><ul>";
                foreach ($errors as $err) echo "<li>$err</li>";
                echo "</ul><a href='?page=mapel'>⬅ Kembali</a>";
            } else {
                header("Location: ?page=mapel_index&status=import_sukses");
                exit;
            }
        }
    }
}
