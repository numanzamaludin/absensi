<?php
require_once __DIR__ . '/../models/GuruModel.php';

class GuruController {
    private $model;

    public function __construct() {
        $this->model = new GuruModel();
    }

    // Fungsi pembatas akses untuk admin saja
    private function hanyaAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die('Akses ditolak: hanya admin yang boleh mengakses.');
        }
    }

    // Tampilkan semua guru
    public function index() {
        $this->hanyaAdmin();
        $data = $this->model->getAll();
        include __DIR__ . '/../views/guru/index.php';
    }

    // Tambah guru
    public function tambah() {
        $this->hanyaAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=guru_index");
            exit;
        }
        include __DIR__ . '/../views/guru/tambah.php';
    }

    // Edit guru
    public function edit() {
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
    public function hapus() {
        $this->hanyaAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=guru_index");
        exit;
    }
}
