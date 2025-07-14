<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<?php
require_once __DIR__ . '/../../models/AbsensiModel.php'; // sesuaikan path jika perlu

$absensiModel = new AbsensiModel();

// Pastikan session mengandung id_siswa
$id_siswa = $_SESSION['user']['id_siswa'] ?? null;
$absensiHariIni = null;

if ($id_siswa) {
    $absensiHariIni = $absensiModel->getAbsensiHariIni($id_siswa);
}
?>


<?php
// Ambil nama siswa dari session
$namaSiswa = isset($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : $_SESSION['user']['email'];
?>

<h2>Dashboard Siswa</h2>

<p>Halo, <?= htmlspecialchars($namaSiswa) ?>!</p>

<p><a href="?page=logout">Logout</a></p>




<hr>
<h3>Absensi Hari Ini</h3>

<?php if (!empty($absensiHariIni)): ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Mata Pelajaran</th>
                <th>Guru Mapel</th>
                <th>Status Kehadiran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($absensiHariIni as $absensi): ?>
                <tr>
                    <td><?= htmlspecialchars($absensi['tanggal']) ?></td>
                    <td><?= htmlspecialchars($absensi['nama_mapel']) ?></td>
                    <td><?= htmlspecialchars($absensi['nama_guru']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($absensi['status_kehadiran'])) ?></td>
                    <td><?= htmlspecialchars($absensi['keterangan'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="color:gray;">Belum ada data absensi untuk hari ini.</p>
<?php endif; ?>

<hr>
<h3>📆 Riwayat Absensi Harian</h3>

<!-- 🔽 Filter -->
<form id="filterRiwayatForm">
    <label>Tanggal:
        <select name="tanggal" id="tanggal">
            <?php for ($d = 1; $d <= 31; $d++): ?>
                <option value="<?= $d ?>" <?= $d == date('j') ? 'selected' : '' ?>><?= $d ?></option>
            <?php endfor; ?>
        </select>
    </label>

    <label>Bulan:
        <select name="bulan" id="bulan">
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>
    </label>

    <label>Tahun:
        <select name="tahun" id="tahun">
            <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
    </label>

    <button type="submit">🔍 Lihat Riwayat</button>
</form>

<!-- 🔁 Tabel hasil -->
<div id="riwayatContainer" style="margin-top: 1rem;">
    <p><em>Silakan pilih tanggal untuk melihat riwayat absensi.</em></p>
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
                document.getElementById('riwayatContainer').innerHTML = '<p style="color:red;">Gagal memuat data.</p>';
            });
    });
</script>