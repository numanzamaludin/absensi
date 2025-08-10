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

$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];

$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date   = $_GET['end_date'] ?? date('Y-m-t');

$allJadwal = [];
$allAbsensi = [];

$period = new DatePeriod(
    new DateTime($start_date),
    new DateInterval('P1D'),
    (new DateTime($end_date))->modify('+1 day')
);

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

$rekapGuru = [];
foreach ($allJadwal as $jadwal) {
    $idGuru = $jadwal['id_guru'];

    if (!isset($rekapGuru[$idGuru])) {
        $rekapGuru[$idGuru] = [
            'nama_guru' => $jadwal['nama_guru'],
            'total_jadwal' => 0,
            'hadir' => 0,
            'tidak_hadir' => 0,
            'detail_tidak_hadir' => []
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
        $rekapGuru[$idGuru]['detail_tidak_hadir'][] = [
            'tanggal' => $jadwal['tanggal'],
            'mapel' => $jadwal['nama_mapel'],
            'kelas' => $jadwal['nama_kelas'],
            'jam_mulai' => $jadwal['jam_mulai'],
            'jam_selesai' => $jadwal['jam_selesai']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>📆 Rekap Absensi Guru Bulanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- DataTables Bootstrap5 CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/rekap_absensi_bulanan.css" />
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">📆 Rekap Absensi Guru Bulanan</h2>
        <a href="?page=dashboard" class="btn btn-outline-secondary mt-4">⬅ Kembali</a>
        <a href="?page=rekap_absensi_bulanan_export&start_date=<?= htmlspecialchars($start_date) ?>&end_date=<?= htmlspecialchars($end_date) ?>" class="btn btn-success mb-3">
            📄 Export Excel
        </a>


        <form method="GET" class="row g-3 align-items-end mb-4">
            <input type="hidden" name="page" value="rekap_absensi_bulanan" />
            <div class="col-sm-12 col-md-4">
                <label for="start_date" class="form-label">Dari:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" required />
            </div>
            <div class="col-sm-12 col-md-4">
                <label for="end_date" class="form-label">Sampai:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" required />
            </div>
            <div class="col-sm-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
                <a href="?page=rekap_absensi_bulanan" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table id="rekapBulanan" class="table table-striped table-bordered align-middle" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Guru</th>
                        <th>Total Jadwal</th>
                        <th>Hadir</th>
                        <th>Tidak Hadir</th>
                        <th>Persentase Kehadiran</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekapGuru as $idGuru => $guru): ?>
                        <tr>
                            <td><?= htmlspecialchars($guru['nama_guru']) ?></td>
                            <td><?= $guru['total_jadwal'] ?></td>
                            <td><?= $guru['hadir'] ?></td>
                            <td><?= $guru['tidak_hadir'] ?></td>
                            <td><?= round(($guru['hadir'] / $guru['total_jadwal']) * 100, 2) ?>%</td>
                            <td>
                                <a href="?page=detail_absensi_guru&id_guru=<?= $idGuru ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-sm btn-info">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>

    <!-- JS: jQuery, Bootstrap, DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/rekap_absensi_bulanan.js"></script>
</body>

</html>