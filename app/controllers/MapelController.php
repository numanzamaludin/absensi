<?php
require_once __DIR__ . '/../models/MapelModel.php';

class MapelController {
    private $model;

    public function __construct() {
        $this->model = new MapelModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/mapel/index.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=mapel_index");
            exit;
        }
        include __DIR__ . '/../views/mapel/tambah.php';
    }

    public function edit() {
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

    public function hapus() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: ?page=mapel_index");
        exit;
    }
}
