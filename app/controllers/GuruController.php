<?php
require_once __DIR__ . '/../models/GuruModel.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class GuruController
{
    private $model;

    public function __construct()
    {
        $this->model = new GuruModel();
    }

    // Fungsi pembatas akses untuk admin saja
    private function hanyaAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die('Akses ditolak: hanya admin yang boleh mengakses.');
        }
    }

    // Tampilkan semua guru
    public function index()
    {
        $this->hanyaAdmin();
        $data = $this->model->getAll();
        include __DIR__ . '/../views/guru/index.php';
    }

    // Tambah guru
    public function tambah()
    {
        $this->hanyaAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=guru_index");
            exit;
        }
        include __DIR__ . '/../views/guru/tambah.php';
    }

    // Edit guru
    public function edit()
    {
        $this->hanyaAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak ditemukan');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=guru_index");
            exit;
        }

        $guru = $this->model->getById($id);
        include __DIR__ . '/../views/guru/edit.php';
    }

    // Hapus guru
    public function hapus()
    {
        $this->hanyaAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=guru_index");
        exit;
    }



    public function importGuruProses()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_excel'])) {
            $file = $_FILES['file_excel']['tmp_name'];

            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            // Lewati baris header
            unset($sheet[0]);

            $errors = [];

            foreach ($sheet as $row) {
                $nama = trim($row[0] ?? '');
                $nip = trim($row[1] ?? '');
                $email = trim($row[2] ?? '');
                $password = trim($row[3] ?? '');

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Email tidak valid: $email";
                    continue;
                }

                if ($this->model->emailExists($email)) {
                    $errors[] = "Email duplikat: $email";
                    continue;
                }

                $this->model->insert([
                    'nama_guru' => $nama,
                    'nip'       => $nip,
                    'email'     => $email,
                    'password'  => $password, // sudah di-hash dalam insert()
                ]);
            }

            if (!empty($errors)) {
                echo "<h4>Beberapa data gagal diimport:</h4><ul>";
                foreach ($errors as $err) echo "<li>$err</li>";
                echo "</ul><a href='?page=guru'>⬅ Kembali</a>";
            } else {
                header("Location: ?page=guru_index");
                exit;
            }
        }
    }
}
