<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/AbsensiModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$jadwalModel = new JadwalModel();
$absensiModel = new AbsensiModel();

$idGuru = $_GET['id_guru'] ?? null;
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate   = $_GET['end_date'] ?? date('Y-m-t');

if (!$idGuru) {
    die("ID Guru tidak ditemukan.");
}

$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];

$dataDetail = [];
$period = new DatePeriod(
    new DateTime($startDate),
    new DateInterval('P1D'),
    (new DateTime($endDate))->modify('+1 day')
);

foreach ($period as $date) {
    $tanggalFull = $date->format('Y-m-d');
    $hariDB = $hariMap[$date->format('l')];

    $jadwalHari = $jadwalModel->getJadwalByHariAndGuru($hariDB, $idGuru);
    $absensiHari = $absensiModel->getAbsensiGuruTanggal($idGuru, $tanggalFull);

    foreach ($jadwalHari as $jadwal) {
        $hadir = false;
        foreach ($absensiHari as $absen) {
            if ($absen['id_jadwal'] == $jadwal['id_jadwal']) {
                $hadir = true;
                break;
            }
        }
        $dataDetail[] = [
            'tanggal'    => $tanggalFull,
            'hari'       => $hariDB,
            'mapel'      => $jadwal['nama_mapel'],
            'kelas'      => $jadwal['nama_kelas'],
            'jam_mulai'  => $jadwal['jam_mulai'],
            'jam_selesai' => $jadwal['jam_selesai'],
            'status'     => $hadir ? 'Hadir' : 'Tidak Hadir'
        ];
    }
}

$namaGuru = $jadwalHari[0]['nama_guru'] ?? 'Guru';

// Mulai bikin spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Detail Absensi');

// Judul laporan dan periode
$sheet->mergeCells('A1:G1');
$sheet->setCellValue('A1', "Detail Absensi Guru: $namaGuru");
$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A2', "Periode: $startDate s/d $endDate");

// Styling judul
$sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Header tabel
$headers = ['Tanggal', 'Hari', 'Kelas', 'Mata Pelajaran', 'Jam Mulai', 'Jam Selesai', 'Status'];
$sheet->fromArray($headers, NULL, 'A4');

// Isi data
$rowStart = 5;
foreach ($dataDetail as $idx => $row) {
    $sheet->setCellValue("A" . ($rowStart + $idx), $row['tanggal']);
    $sheet->setCellValue("B" . ($rowStart + $idx), $row['hari']);
    $sheet->setCellValue("C" . ($rowStart + $idx), $row['kelas']);
    $sheet->setCellValue("D" . ($rowStart + $idx), $row['mapel']);
    $sheet->setCellValue("E" . ($rowStart + $idx), $row['jam_mulai']);
    $sheet->setCellValue("F" . ($rowStart + $idx), $row['jam_selesai']);
    $sheet->setCellValue("G" . ($rowStart + $idx), $row['status']);
}

// Auto size kolom
foreach (range('A', 'G') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Styling header tabel
$sheet->getStyle('A4:G4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
$sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$sheet->getStyle('A4:G4')->getFill()->getStartColor()->setARGB('FF000000'); // hitam background
$sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Warna teks status
$highestRow = $sheet->getHighestRow();
for ($row = $rowStart; $row <= $highestRow; $row++) {
    $statusCell = $sheet->getCell("G$row")->getValue();
    if ($statusCell === 'Hadir') {
        $sheet->getStyle("G$row")->getFont()->getColor()->setARGB('FF008000'); // hijau
    } else {
        $sheet->getStyle("G$row")->getFont()->getColor()->setARGB('FFFF0000'); // merah
    }
}

// Header supaya langsung download file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="detail_absensi_' . $namaGuru . '_' . $startDate . '_sd_' . $endDate . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
