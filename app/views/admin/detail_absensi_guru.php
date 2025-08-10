<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/../../models/JadwalModel.php';
require_once __DIR__ . '/../../models/AbsensiModel.php';

$jadwalModel = new JadwalModel();
$absensiModel = new AbsensiModel();

$idGuru = $_GET['id_guru'] ?? null;
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate   = $_GET['end_date'] ?? date('Y-m-t');

if (!$idGuru) {
    echo "<p>ID Guru tidak ditemukan.</p>";
    exit;
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

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Detail Absensi Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/detail_absensi_guru.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-3">📋 Detail Absensi Guru</h2>

        <a href="?page=rekap_absensi_bulanan&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>" class="btn btn-secondary mt-3">
            ⬅ Kembali
        </a>
        <a href="?page=rekap_absensi_detail_export&id_guru=<?= urlencode($idGuru) ?>&start_date=<?= htmlspecialchars($startDate) ?>&end_date=<?= htmlspecialchars($endDate) ?>" class="btn btn-success mb-3">
            📄 Export Excel
        </a>


        <p>Nama Guru: <strong><?= htmlspecialchars($namaGuru) ?></strong></p>
        <p>Periode: <?= htmlspecialchars($startDate) ?> s/d <?= htmlspecialchars($endDate) ?></p>

        <div class="table-responsive">
            <table id="detailAbsensi" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataDetail as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['hari']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td><?= htmlspecialchars($row['mapel']) ?></td>
                            <td><?= htmlspecialchars($row['jam_mulai']) ?></td>
                            <td><?= htmlspecialchars($row['jam_selesai']) ?></td>
                            <td class="<?= $row['status'] === 'Hadir' ? 'text-success' : 'text-danger' ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/detail_absensi_guru.js"></script>
</body>

</html>