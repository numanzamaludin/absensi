<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

require_once __DIR__ . '/../../vendor/autoload.php'; // path ke autoload composer
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/AbsensiModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

date_default_timezone_set('Asia/Jakarta');

$jadwalModel = new JadwalModel();
$absensiModel = new AbsensiModel();

$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];

// Ambil filter tanggal
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date   = $_GET['end_date'] ?? date('Y-m-t');

$period = new DatePeriod(
    new DateTime($start_date),
    new DateInterval('P1D'),
    (new DateTime($end_date))->modify('+1 day')
);

$allJadwal = [];
$allAbsensi = [];

foreach ($period as $date) {
    $tanggalFull = $date->format('Y-m-d');
    $hariDB = $hariMap[$date->format('l')];

    $jadwalHari = $jadwalModel->getJadwalByHari($hariDB);
    $absensiHari = $absensiModel->getAbsensiHariIniAdmin($tanggalFull);

    foreach ($jadwalHari as $jadwal) {
        $jadwal['tanggal'] = $tanggalFull;
        $allJadwal[] = $jadwal;
    }
    foreach ($absensiHari as $absen) {
        $allAbsensi[] = $absen;
    }
}

// Rekap guru
$rekapGuru = [];
foreach ($allJadwal as $jadwal) {
    $idGuru = $jadwal['id_guru'];

    if (!isset($rekapGuru[$idGuru])) {
        $rekapGuru[$idGuru] = [
            'nama_guru' => $jadwal['nama_guru'],
            'total_jadwal' => 0,
            'hadir' => 0,
            'tidak_hadir' => 0,
        ];
    }

    $rekapGuru[$idGuru]['total_jadwal']++;

    $hadir = false;
    foreach ($allAbsensi as $absen) {
        if (
            $absen['id_guru'] == $jadwal['id_guru'] &&
            $absen['id_jadwal'] == $jadwal['id_jadwal'] &&
            $absen['tanggal'] == $jadwal['tanggal']
        ) {
            $hadir = true;
            break;
        }
    }

    if ($hadir) {
        $rekapGuru[$idGuru]['hadir']++;
    } else {
        $rekapGuru[$idGuru]['tidak_hadir']++;
    }
}

// Buat Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// --- Tambah judul dan info range tanggal ---
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('A1', 'Rekap Absensi Guru');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$rangeText = 'Periode: ' . date('d M Y', strtotime($start_date)) . ' s.d. ' . date('d M Y', strtotime($end_date));
$sheet->mergeCells('A2:E2');
$sheet->setCellValue('A2', $rangeText);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// --- Header tabel ---
$header = ['Nama Guru', 'Total Jadwal', 'Hadir', 'Tidak Hadir', 'Persentase Kehadiran (%)'];
$sheet->fromArray($header, NULL, 'A4');

// Styling header: background hitam, font putih, border
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '000000']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
];
$sheet->getStyle('A4:E4')->applyFromArray($headerStyle);

// Isi data mulai baris 5
$row = 5;
foreach ($rekapGuru as $guru) {
    $percentage = $guru['total_jadwal'] > 0 ? round(($guru['hadir'] / $guru['total_jadwal']) * 100, 2) : 0;

    $sheet->setCellValue("A{$row}", $guru['nama_guru']);
    $sheet->setCellValue("B{$row}", $guru['total_jadwal']);
    $sheet->setCellValue("C{$row}", $guru['hadir']);
    $sheet->setCellValue("D{$row}", $guru['tidak_hadir']);
    $sheet->setCellValue("E{$row}", $percentage);
    $row++;
}

// Auto size kolom
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Border untuk data
$dataRange = 'A4:E' . ($row - 1);
$sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Align data ke tengah kecuali kolom Nama Guru
$sheet->getStyle("B5:E" . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Output file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="rekap_absensi_bulanan_' . $start_date . '_sd_' . $end_date . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
