<?php
require_once __DIR__ . '/../models/GuruMapelModel.php';
require_once __DIR__ . '/../models/GuruModel.php';
require_once __DIR__ . '/../models/MapelModel.php';
require_once __DIR__ . '/../models/KelasModel.php';


class GuruMapelController
{
    private $model;

    public function __construct()
    {
        $this->model = new GuruMapelModel();
    }

    public function index()
    {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/guru_mapel/index.php';
    }

    public function tambah()
    {
        $guruModel = new GuruModel();
        $mapelModel = new MapelModel();
        $gurus = $guruModel->getAll();
        $mapels = $mapelModel->getAll();
        $kelasModel = new KelasModel();
        $kelasmapels = $kelasModel->getAll();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->insert($_POST);
            header("Location: ?page=guru_mapel_index");
            exit;
        }

        include __DIR__ . '/../views/guru_mapel/tambah.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak ditemukan');

        $kelasModel = new KelasModel();
        $kelas = $kelasModel->getAll();

        $guruModel = new GuruModel();
        $mapelModel = new MapelModel();
        $gurus = $guruModel->getAll();
        $mapels = $mapelModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: ?page=guru_mapel_index");
            exit;
        }

        $data = $this->model->getById($id);
        include __DIR__ . '/../views/guru_mapel/edit.php';
    }

    public function hapus()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: ?page=guru_mapel_index&status=invalid_id");
            exit;
        }

        if ($this->model->isUsedInAbsensi($id)) {
            header("Location: ?page=guru_mapel_index&status=terkait_absensi");
            exit;
        }





        $this->model->delete($id);
        header("Location: ?page=guru_mapel_index&status=sukses");
        exit;
    }
}
