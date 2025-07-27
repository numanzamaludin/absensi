<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

require_once __DIR__ . '/../../models/AbsensiModel.php';
$absensiModel = new AbsensiModel();
$id_siswa = $_SESSION['user']['id_siswa'] ?? null;
$absensiHariIni = $id_siswa ? $absensiModel->getAbsensiHariIni($id_siswa) : [];

$namaSiswa = $_SESSION['user']['nama'] ?? $_SESSION['user']['email'] ?? 'Siswa';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="assets/css/dashboard_siswa.css">
</head>

<body>

    <h2>🎓 Dashboard Siswa</h2>

    <div class="card">
        <p>Halo, <strong><?= htmlspecialchars($namaSiswa) ?></strong></p>
        <p><a href="?page=logout">🚪 Logout</a></p>
    </div>

    <div class="card">
        <h3>📅 Absensi Hari Ini</h3>
        <?php if (!empty($absensiHariIni)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Mapel</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($absensiHariIni as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['tanggal']) ?></td>
                            <td><?= htmlspecialchars($a['nama_mapel']) ?></td>
                            <td><?= htmlspecialchars($a['nama_guru']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($a['status_kehadiran'])) ?></td>
                            <td><?= htmlspecialchars($a['keterangan'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="muted">Belum ada data absensi untuk hari ini.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>📆 Riwayat Absensi Harian</h3>
        <form id="filterRiwayatForm">
            <div class="filter-row">
                <label>
                    Tanggal:
                    <select name="tanggal" id="tanggal">
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <option value="<?= $d ?>" <?= $d == date('j') ? 'selected' : '' ?>><?= $d ?></option>
                        <?php endfor; ?>
                    </select>
                </label>

                <label>
                    Bulan:
                    <select name="bulan" id="bulan">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>

                <label>
                    Tahun:
                    <select name="tahun" id="tahun">
                        <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                            <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </label>

                <button type="submit">🔍 Lihat Riwayat</button>
            </div>
        </form>


        <div id="riwayatContainer" style="margin-top: 1rem;">
            <p class="muted">Silakan pilih tanggal untuk melihat riwayat absensi.</p>
        </div>
    </div>

    <script>
        document.getElementById('filterRiwayatForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const tanggal = document.getElementById('tanggal').value;
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            fetch(`index.php?page=ajax_riwayat_absensi&tanggal=${tanggal}&bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('riwayatContainer').innerHTML = html;
                })
                .catch(err => {
                    document.getElementById('riwayatContainer').innerHTML = '<p class="muted" style="color:red;">Gagal memuat data.</p>';
                });
        });
    </script>

</body>

</html>