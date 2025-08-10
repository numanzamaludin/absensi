<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/AbsensiModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Ambil parameter tanggal
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Mapping hari
$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];
$hariDB = $hariMap[date('l', strtotime($tanggal))];

// Ambil data
$jadwalModel = new JadwalModel();
$absensiModel = new AbsensiModel();

$jadwalHariIni = $jadwalModel->getJadwalByHari($hariDB);
$absensiHariIni = $absensiModel->getAbsensiHariIniAdmin($tanggal);

// Gabungkan data
$jadwalGabung = [];
foreach ($jadwalHariIni as $jadwal) {
    $sudahAbsen = false;
    $waktuAbsen = '-';
    foreach ($absensiHariIni as $absen) {
        if ($absen['id_guru'] == $jadwal['id_guru'] && $absen['id_jadwal'] == $jadwal['id_jadwal']) {
            $sudahAbsen = true;
            $waktuAbsen = $absen['waktu'];
            break;
        }
    }
    $jadwal['sudah_absen'] = $sudahAbsen ? 'Hadir' : 'Belum Absen';
    $jadwal['waktu_absen'] = $waktuAbsen;
    $jadwalGabung[] = $jadwal;
}

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul Laporan
$sheet->setCellValue('A1', 'Rekap Absensi Harian Guru');
$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

// Info tanggal
$sheet->setCellValue('A2', 'Tanggal: ' . date('d-m-Y', strtotime($tanggal)));
$sheet->mergeCells('A2:G2');
$sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

// Header tabel
$headers = ['Guru', 'Mata Pelajaran', 'Kelas', 'Jam Mulai', 'Jam Selesai', 'Status', 'Waktu Absen'];
$sheet->fromArray($headers, NULL, 'A4');

// Style header
$sheet->getStyle('A4:G4')->getFont()->setBold(true);
$sheet->getStyle('A4:G4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
$sheet->getStyle('A4:G4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Data tabel
$rowNum = 5;
foreach ($jadwalGabung as $row) {
    $sheet->setCellValue("A$rowNum", $row['nama_guru']);
    $sheet->setCellValue("B$rowNum", $row['nama_mapel']);
    $sheet->setCellValue("C$rowNum", $row['nama_kelas']);
    $sheet->setCellValue("D$rowNum", $row['jam_mulai']);
    $sheet->setCellValue("E$rowNum", $row['jam_selesai']);
    $sheet->setCellValue("F$rowNum", $row['sudah_absen']);
    $sheet->setCellValue("G$rowNum", $row['waktu_absen']);
    $rowNum++;
}

// Style border data
$sheet->getStyle("A4:G" . ($rowNum - 1))
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Auto size kolom
foreach (range('A', 'G') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Export file
$filename = "rekap_absensi_harian_{$tanggal}.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
