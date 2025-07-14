<?php
require_once __DIR__ . '/../models/WaliKelasModel.php';
require_once __DIR__ . '/../models/GuruModel.php';
require_once __DIR__ . '/../models/KelasModel.php';

class WaliKelasController {
    private $model;

    public function __construct() {
        $this->model = new WaliKelasModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/wali_kelas/index.php';
    }

    public function tambah() {
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();

        $gurus = $guruModel->getAll();
        $kelas = $kelasModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=wali_kelas_index");
            exit;
        }

        include __DIR__ . '/../views/wali_kelas/tambah.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak ditemukan');

        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();

        $gurus = $guruModel->getAll();
        $kelas = $kelasModel->getAll();
        $wali = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=wali_kelas_index");
            exit;
        }

        include __DIR__ . '/../views/wali_kelas/edit.php';
    }

    public function hapus() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=wali_kelas_index");
        exit;
    }
}
