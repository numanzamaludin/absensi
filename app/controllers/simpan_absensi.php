<?php
require_once __DIR__ . '/../models/GuruMapelModel.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/AbsensiModel.php';
require_once __DIR__ . '/../models/DashboardModel.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guru') {
    die('Akses ditolak.');
}

$guruId     = $_SESSION['user']['id'];
$id_kelas   = $_POST['id_kelas'] ?? null;
$id_mapel   = $_POST['id_mapel'] ?? null;
$tanggal    = $_POST['tanggal'] ?? date('Y-m-d');
$absensi    = $_POST['absensi'] ?? [];
$keterangan = $_POST['keterangan'] ?? [];

if (!$id_kelas || !$id_mapel) {
    die('ID Kelas atau Mapel tidak ditemukan.');
}

$dashboardModel = new DashboardModel();
$id_guru_mapel = $dashboardModel->getGuruMapelId($guruId, $id_mapel);

if (!$id_guru_mapel) {
    die("Gagal menemukan ID guru_mapel untuk guru ID: $guruId dan mapel ID: $id_mapel");
}

// Ambil data guru_mapel lengkap
$guruMapelModel = new GuruMapelModel();
$guru_mapel = $guruMapelModel->getById($id_guru_mapel);

$id_guru  = $guru_mapel['id_guru'];
$id_mapel = $guru_mapel['id_mapel'];
$id_kelas = $guru_mapel['id_kelas'];

// Validasi hari dan jam pelajaran
$jadwalModel = new JadwalModel();

$hari_map = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
];
$hari_eng = date('l');
$hari     = $hari_map[$hari_eng];
$jam      = date('H:i:s');


echo "<pre>";
echo "ID Guru: $id_guru\n";
echo "ID Mapel: $id_mapel\n";
echo "ID Kelas: $id_kelas\n";
echo "Hari: $hari\n";
echo "Jam sekarang: $jam\n";
echo "</pre>";

// Ambil jadwal berdasarkan guru-mapel-kelas-hari-jam
$jadwal = $jadwalModel->findByGuruMapelHariJam($id_guru, $id_mapel, $id_kelas, $hari, $jam);

if (!$jadwal) {
    die("❌ Gagal: Anda tidak dijadwalkan mengajar pada hari $hari dan jam ini.");
}

// Cek apakah sudah ada absensi hari ini
$absensiModel = new AbsensiModel();
$existing = $absensiModel->absensiSudahAda($id_guru_mapel, $id_kelas, $tanggal);
if ($existing) {
    die('Absensi untuk tanggal ini sudah dibuat.');
}

// Simpan absensi (header)
$id_absensi = $absensiModel->insertAbsensi($id_guru_mapel, $id_kelas, $tanggal, $guruId);

// Simpan setiap detail siswa
foreach ($absensi as $id_siswa => $status) {
    $keterangan_siswa = $keterangan[$id_siswa] ?? null;
    $absensiModel->insertAbsensiDetail($id_absensi, $id_siswa, $status, $keterangan_siswa);
}

echo "<script>alert('Absensi berhasil disimpan'); window.location.href='?page=dashboard';</script>";
