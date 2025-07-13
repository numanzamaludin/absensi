<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/SiswaModel.php'; // Ganti ke SiswaModel
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ImportSiswaController
{
    public function import()
    {
        require_login('admin'); // Hanya bisa diakses admin

        $db = Database::getConnection();

        if (!isset($_FILES['file']['tmp_name'])) {
            echo "File tidak ditemukan.";
            return;
        }

        $filePath = $_FILES['file']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $model = new SiswaModel();

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                $nama = $row[0] ?? '';
                $nis = $row[1] ?? '';
                $email = $row[2] ?? '';
                $password = $row[3] ?? '';
                $id_kelas_raw = $row[4] ?? '';
                $id_kelas = explode(' - ', $id_kelas_raw)[0] ?? '';

                $stmt = $db->prepare("SELECT COUNT(*) FROM kelas WHERE id_kelas = ?");
                $stmt->execute([$id_kelas]);
                $kelasExists = $stmt->fetchColumn() > 0;

                if ($nama && $email && $nis && $password && $id_kelas && $kelasExists) {
                    $model->insert([
                        'nama_siswa' => $nama,
                        'nis' => $nis,
                        'email' => $email,
                        'password' => $password, // hashing dilakukan di model
                        'id_kelas' => $id_kelas
                    ]);
                } else {
                    echo "Baris ke " . ($i + 1) . " dilewati karena data tidak lengkap atau id_kelas tidak valid.<br>";
                }
            }

            echo "Import selesai. <a href='?page=import_siswa'>Kembali</a>";
        } catch (Exception $e) {
            echo "Gagal membaca file Excel: " . $e->getMessage();
        }
    }

    public function downloadTemplate()
    {
        require_login('admin'); // Hanya bisa diakses admin

        $db = Database::getConnection();
        $stmt = $db->query("SELECT id_kelas, nama_kelas FROM kelas");
        $kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'nama_siswa');
        $sheet->setCellValue('B1', 'nis');
        $sheet->setCellValue('C1', 'email');
        $sheet->setCellValue('D1', 'password');
        $sheet->setCellValue('E1', 'id_kelas');

        // Tambahkan sheet tersembunyi untuk dropdown
        $kelasSheet = $spreadsheet->createSheet();
        $kelasSheet->setTitle('KelasList');

        $row = 1;
        foreach ($kelasList as $kelas) {
            $kelasSheet->setCellValue('A' . $row, $kelas['id_kelas'] . ' - ' . $kelas['nama_kelas']);
            $row++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $kelasSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

        // Data validation (dropdown) di kolom E
        for ($i = 2; $i <= 100; $i++) {
            $validation = $sheet->getCell("E$i")->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1("'KelasList'!A1:A" . count($kelasList));
        }

        // Output file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_import_siswa.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
