<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

date_default_timezone_set('Asia/Jakarta');

// Ambil tanggal dari form, default hari ini
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Mapping hari ke bahasa Indonesia
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

// Ambil data dari model
require_once __DIR__ . '/../../models/JadwalModel.php';
require_once __DIR__ . '/../../models/AbsensiModel.php';

$jadwalModel = new JadwalModel();
$absensiModel = new AbsensiModel();

$jadwalHariIni = $jadwalModel->getJadwalByHari($hariDB);
$absensiHariIni = $absensiModel->getAbsensiHariIniAdmin($tanggal);

// Gabungkan data jadwal + absensi
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
    $jadwal['sudah_absen'] = $sudahAbsen;
    $jadwal['waktu_absen'] = $waktuAbsen;
    $jadwalGabung[] = $jadwal;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Harian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/rekap_absensi_harian.css">
</head>

<body>


    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="mb-3 mb-md-0">📅 Rekap Absensi Harian</h2>
            <a href="?page=rekap_absensi_harian_export&tanggal=<?= htmlspecialchars($tanggal) ?>"
                class="btn btn-success">
                📄 Export Excel
            </a>
        </div>
        <div class="mt-3">
            <a href="?page=dashboard" class="btn btn-outline-primary">⬅ Kembali</a>
        </div>
        <form method="GET" class="row g-3 mb-3">
            <input type="hidden" name="page" value="rekap_absensi_harian">
            <div class="col-md-4 col-12">
                <label for="tanggal" class="form-label">Pilih Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" value="<?= htmlspecialchars($tanggal) ?>" class="form-control">
            </div>
            <div class="col-md-4 col-12 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="?page=rekap_absensi_harian" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <p class="fw-bold">
            Tanggal: <?= date('d-m-Y', strtotime($tanggal)) ?> (<?= $hariDB ?>)
        </p>

        <div class="table-responsive">
            <table id="rekapTable" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                        <th>Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($jadwalGabung) > 0): ?>
                        <?php foreach ($jadwalGabung as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                                <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($row['jam_mulai']) ?></td>
                                <td><?= htmlspecialchars($row['jam_selesai']) ?></td>
                                <td>
                                    <?php if ($row['sudah_absen']): ?>
                                        <span class="badge bg-success">✅ Hadir</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">❌ Belum Absen</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['waktu_absen']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center" style="font-style: italic; color: #888;">
                                Tidak ada data untuk tanggal ini
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>


    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            let $tbody = $('#rekapTable tbody');
            let trs = $tbody.find('tr');

            trs.each(function() {
                if ($(this).children('td, th').length !== 7) {
                    $(this).remove();
                }
            });

            if ($.fn.DataTable.isDataTable('#rekapTable')) {
                $('#rekapTable').DataTable().destroy();
            }

            $('#rekapTable').DataTable({
                pageLength: 100,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                responsive: true
            });
        });
    </script>


</body>

</html>