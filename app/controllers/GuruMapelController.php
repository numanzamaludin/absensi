<?php
require_once __DIR__ . '/../models/GuruMapelModel.php';
require_once __DIR__ . '/../models/GuruModel.php';
require_once __DIR__ . '/../models/MapelModel.php';
require_once __DIR__ . '/../models/KelasModel.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


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










    public function importExcel()
    {
        require_once __DIR__ . '/../../vendor/autoload.php'; // Pastikan path ini benar

        if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== 0) {
            $_SESSION['flash'] = 'Gagal mengunggah file Excel.';
            header('Location: ?page=guru_mapel');
            exit;
        }

        try {
            $filePath = $_FILES['import_file']['tmp_name'];
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $isHeader = true;
            $sukses = 0;
            $gagal = 0;

            foreach ($rows as $row) {
                if ($isHeader) {
                    $isHeader = false;
                    continue; // lewati baris header
                }

                // Lewati baris kosong
                if (empty($row[0]) && empty($row[1]) && empty($row[2])) {
                    continue;
                }

                // Ambil data, trim untuk bersih dari spasi
                [$namaGuru, $namaMapel, $namaKelas] = array_map('trim', $row);

                // Validasi minimal
                if ($namaGuru && $namaMapel && $namaKelas) {
                    $this->model->importGuruMapel($namaGuru, $namaMapel, $namaKelas);
                    $sukses++;
                } else {
                    $gagal++;
                }
            }

            $_SESSION['flash'] = "Import selesai. Berhasil: $sukses. Gagal: $gagal.";
        } catch (Exception $e) {
            $_SESSION['flash'] = 'Terjadi kesalahan saat memproses file: ' . $e->getMessage();
        }

        header('Location: ?page=guru_mapel_index');
        exit;
    }



    public function unduhTemplate()
    {
        // Load model
        $guruList  = $this->model->getGuru();     // ex: [['nama_guru' => 'Ahmad']]
        $mapelList = $this->model->getMapel();    // ex: [['nama_mapel' => 'Matematika']]
        $kelasList = $this->model->getKelas();    // ex: [['nama_kelas' => 'X IPA 1']]

        $spreadsheet = new Spreadsheet();

        // Sheet utama
        $mainSheet = $spreadsheet->getActiveSheet();
        $mainSheet->setTitle('Template Import');
        $mainSheet->setCellValue('A1', 'Nama Guru');
        $mainSheet->setCellValue('B1', 'Mata Pelajaran');
        $mainSheet->setCellValue('C1', 'Kelas');

        // Sheet Dropdown
        $dropdownSheet = new Worksheet($spreadsheet, 'Dropdown');
        $spreadsheet->addSheet($dropdownSheet);

        // Masukkan data dropdown
        foreach ($guruList as $i => $guru) {
            $dropdownSheet->setCellValue('A' . ($i + 1), $guru['nama_guru']);
        }
        foreach ($mapelList as $i => $mapel) {
            $dropdownSheet->setCellValue('B' . ($i + 1), $mapel['nama_mapel']);
        }
        foreach ($kelasList as $i => $kelas) {
            $dropdownSheet->setCellValue('C' . ($i + 1), $kelas['nama_kelas']);
        }

        $lastGuruRow  = count($guruList);
        $lastMapelRow = count($mapelList);
        $lastKelasRow = count($kelasList);

        // Data validation template
        $dvGuru = new DataValidation();
        $dvGuru->setType(DataValidation::TYPE_LIST);
        $dvGuru->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dvGuru->setAllowBlank(false);
        $dvGuru->setShowInputMessage(true);
        $dvGuru->setShowErrorMessage(true);
        $dvGuru->setShowDropDown(true);
        $dvGuru->setFormula1("=Dropdown!A1:A$lastGuruRow");

        $dvMapel = clone $dvGuru;
        $dvMapel->setFormula1("=Dropdown!B1:B$lastMapelRow");

        $dvKelas = clone $dvGuru;
        $dvKelas->setFormula1("=Dropdown!C1:C$lastKelasRow");

        // Pasang data validation ke baris 2–100
        for ($row = 2; $row <= 100; $row++) {
            $mainSheet->getCell("A$row")->setDataValidation(clone $dvGuru);
            $mainSheet->getCell("B$row")->setDataValidation(clone $dvMapel);
            $mainSheet->getCell("C$row")->setDataValidation(clone $dvKelas);
        }

        // Sembunyikan sheet dropdown
        $dropdownSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
        $spreadsheet->setActiveSheetIndex(0);

        // Output ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_guru_mapel.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
