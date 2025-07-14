<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$namaGuru = $_SESSION['user']['nama'] ?? $_SESSION['user']['email'];

include(__DIR__ . '/../partials/header.php');
?>

<link rel="stylesheet" href="/absensi2/public/assets/css/dashboard.css">

<div class="dashboard-container">
    <div class="section-card">
        <h2>Dashboard Guru</h2>
        <p>Halo, <strong><?= htmlspecialchars($namaGuru) ?></strong>!</p>
        <a href="?page=logout" class="btn danger">Logout</a>
    </div>

    <div class="section-card">
        <h3>Mata Pelajaran yang Diampu</h3>
        <?php if (!empty($mapel)): ?>
            <ul class="list">
                <?php foreach ($mapel as $m): ?>
                    <li><?= htmlspecialchars($m['nama_mapel'] ?? '-') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert">Belum ada mata pelajaran.</div>
        <?php endif; ?>
    </div>

    <?php if ($isWaliKelas): ?>
        <div class="section-card">
            <h3>Anda adalah Wali Kelas pada:</h3>
            <ul class="list">
                <?php foreach ($kelasWali as $k): ?>
                    <li><?= htmlspecialchars($k['nama_kelas']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="section-card">
        <h3>Form Absensi</h3>
        <form method="GET" action="">
            <input type="hidden" name="page" value="absensi">
            <div class="form-row">
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelasList as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mapel">Mapel</label>
                    <select name="mapel" id="mapel" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach ($mapel as $m): ?>
                            <option value="<?= $m['id_mapel'] ?? '' ?>"><?= htmlspecialchars($m['nama_mapel'] ?? '-') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn primary">Isi Absensi</button>
        </form>
    </div>

    <div class="section-card">
        <h3>✅ Absensi Menunggu Persetujuan</h3>
        <?php if (!empty($absensiPendingGuru)): ?>
            <ul class="list">
                <?php foreach ($absensiPendingGuru as $a): ?>
                    <li><?= $a['tanggal'] ?> - <?= $a['nama_kelas'] ?> - <?= $a['nama_mapel'] ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert">Tidak ada absensi yang menunggu persetujuan.</div>
        <?php endif; ?>
    </div>

    <div class="section-card">
        <h3>✏️ Absensi Perlu Direvisi</h3>
        <?php if (!empty($absensiDitolak)): ?>
            <ul class="list">
                <?php foreach ($absensiDitolak as $a): ?>
                    <li>
                        <?= $a['tanggal'] ?> - <?= $a['nama_kelas'] ?> - <?= $a['nama_mapel'] ?>
                        <div class="btn-group">
                            <a href="?page=edit_absensi&id=<?= $a['id_absensi'] ?>" class="btn warning">Edit</a>
                            <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>" class="btn info">Lihat</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert">Tidak ada absensi yang ditolak.</div>
        <?php endif; ?>
    </div>

    <?php if ($isWaliKelas): ?>
        <div class="section-card">
            <h3>📌 Persetujuan Wali Kelas</h3>
            <?php if (!empty($absensiPendingWali)): ?>
                <?php foreach ($absensiPendingWali as $a): ?>
                    <div class="approval-card">
                        <div><strong><?= $a['tanggal'] ?></strong></div>
                        <div><?= $a['nama_kelas'] ?></div>
                        <div><?= $a['nama_mapel'] ?></div>
                        <div><span class="status"><?= $a['status_wali_kelas'] ?></span></div>
                        <div class="btn-group center">
                            <form method="POST" action="?page=persetujuan_absensi" style="display:inline;">
                                <input type="hidden" name="id_absensi" value="<?= $a['id_absensi'] ?>">
                                <button type="submit" name="aksi" value="setuju" class="btn small success">✔</button>
                                <button type="submit" name="aksi" value="tolak" class="btn small danger">✘</button>
                            </form>
                            <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>" class="btn small info">👁</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert">Tidak ada absensi yang menunggu persetujuan.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>