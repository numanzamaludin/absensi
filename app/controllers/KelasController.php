<?php
require_once __DIR__ . '/../models/KelasModel.php';

class KelasController {
    private $model;

    public function __construct() {
        $this->model = new KelasModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/kelas/index.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=kelas_index");
            exit;
        }
        include __DIR__ . '/../views/kelas/tambah.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak ditemukan');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=kelas_index");
            exit;
        }

        $kelas = $this->model->getById($id);
        include __DIR__ . '/../views/kelas/edit.php';
    }

    public function hapus() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=kelas_index");
        exit;
    }
}
