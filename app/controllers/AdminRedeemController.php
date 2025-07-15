<?php
// File: app/controllers/AdminRedeemController.php

require_once __DIR__ . '/../models/RedeemModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AdminRedeemController
{
    private $model;

    public function __construct()
    {
        $this->model = new RedeemModel();
    }

    public function index()
    {
        include __DIR__ . '/../views/dashboard/redeem_massal.php';
    }

    public function import()
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            header('Location: ?page=admin_redeem&status=error');
            return;
        }

        try {
            $spreadsheet = (new Xlsx())->load($_FILES['file']['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) < 2) {
                header('Location: ?page=admin_redeem&status=empty');
                return;
            }

            $header = array_map('strtolower', $rows[0]);
            $namaIndex = array_search('nama', $header);
            $roleIndex = array_search('role', $header);
            $kelasIndex = array_search('kelas', $header); // bisa tidak ada

            if ($namaIndex === false || $roleIndex === false) {
                header('Location: ?page=admin_redeem&status=invalid_format');
                return;
            }

            unset($rows[0]); // Hapus header

            foreach ($rows as $row) {
                $nama = trim($row[$namaIndex] ?? '');
                $role = strtolower(trim($row[$roleIndex] ?? ''));
                $kelas = $kelasIndex !== false ? trim($row[$kelasIndex] ?? '') : null;

                if (empty($nama) || !in_array($role, ['guru', 'siswa'])) {
                    continue;
                }

                if ($role === 'siswa' && empty($kelas)) {
                    continue;
                }

                $email = $this->generateEmail($nama, $role);
                $this->model->insertAkun($nama, $email, $role, $kelas);
            }

            header('Location: ?page=admin_redeem&status=success');
        } catch (\Throwable $e) {
            error_log('IMPORT ERROR: ' . $e->getMessage());
            header('Location: ?page=admin_redeem&status=error');
        }
    }

    public function export()
    {
        try {
            $akun = $this->model->getAllAkun();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['Nama', 'Email', 'Role', 'Kelas'], null, 'A1');

            $i = 2;
            foreach ($akun as $a) {
                $sheet->setCellValue("A$i", $a['nama']);
                $sheet->setCellValue("B$i", $a['email']);
                $sheet->setCellValue("C$i", $a['role']);
                $sheet->setCellValue("D$i", $a['kelas'] ?? '');
                $i++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="akun_email.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new WriterXlsx($spreadsheet);
            $writer->save('php://output');
        } catch (\Throwable $e) {
            error_log('EXPORT ERROR: ' . $e->getMessage());
            echo "Gagal melakukan export.";
        }
    }

    private function generateEmail($nama, $role)
    {
        $slug = strtolower(trim($nama));
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug); // transliterasi
        $slug = preg_replace('/[^a-z0-9]+/', '.', $slug); // ganti karakter non-alfanumerik
        $slug = trim($slug, '.');

        $domain = $role === 'guru' ? 'guru.smkperkasa.sch.id' : 'siswa.smkperkasa.sch.id';
        $base = $slug;
        $email = "$slug@$domain";

        $i = 1;
        while ($this->model->emailExists($email)) {
            $slug = "$base$i";
            $email = "$slug@$domain";
            $i++;
        }

        return $email;
    }






    public function create()
    {
        include __DIR__ . '/../views/dashboard/redeem_form.php';
    }

    public function store()
    {
        $nama = $_POST['nama'] ?? '';
        $role = $_POST['role'] ?? '';
        $kelas = $_POST['kelas'] ?? null;

        if ($nama && $role) {
            $email = $this->generateEmail($nama, $role);
            $this->model->insertAkun($nama, $email, $role, $kelas);
        }

        header('Location: ?page=admin_redeem');
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) return;

        $akun = $this->model->getById($id);
        include __DIR__ . '/../views/dashboard/redeem_form.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $nama = $_POST['nama'] ?? '';
        $role = $_POST['role'] ?? '';
        $kelas = $_POST['kelas'] ?? null;

        if ($id && $nama && $role) {
            $this->model->updateAkun($id, $nama, $role, $kelas);
        }

        header('Location: ?page=admin_redeem');
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->deleteAkun($id);
        }
        header('Location: ?page=admin_redeem');
    }
}
