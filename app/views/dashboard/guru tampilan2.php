<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$namaGuru = $_SESSION['user']['nama'] ?? $_SESSION['user']['email'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Guru</title>
</head>

<body>
    <h2>Dashboard Guru</h2>

    <hr>
    <p>Halo, <?= htmlspecialchars($namaGuru) ?>!</p>
    <?php if ($isWaliKelas): ?>
        <p>Anda adalah wali kelas pada kelas:</p>

        <?php foreach ($kelasWali as $k): ?>
            <?= htmlspecialchars($k['nama_kelas']) ?>
        <?php endforeach; ?>

    <?php else: ?>
        <h3>Anda bukan wali kelas.</h3>
    <?php endif; ?>

    <hr>

    <p><a href="?page=logout">Logout</a></p>

    <h3>Mata Pelajaran yang Diampu:</h3>
    <ul>
        <?php if (!empty($mapel)): ?>
            <?php foreach ($mapel as $m): ?>
                <li><?= htmlspecialchars($m['nama_mapel'] ?? '-') ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Belum ada mata pelajaran.</li>
        <?php endif; ?>
    </ul>

    <hr>

    <h3>Form Absensi</h3>
    <form method="GET" action="">
        <input type="hidden" name="page" value="absensi">
        <label for="kelas">Pilih Kelas:</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelasList as $k): ?>
                <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="mapel">Pilih Mapel:</label>
        <select name="mapel" required>
            <option value="">-- Pilih Mapel --</option>
            <?php foreach ($mapel as $m): ?>
                <option value="<?= $m['id_mapel'] ?? '' ?>"><?= htmlspecialchars($m['nama_mapel'] ?? '-') ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Isi Absensi</button>
    </form>

    <hr>

    <h3>✅ Absensi yang Anda Ajukan (Menunggu Persetujuan)</h3>
    <?php if (!empty($absensiPendingGuru)): ?>
        <ul>
            <?php foreach ($absensiPendingGuru as $a): ?>
                <li><?= $a['tanggal'] ?> - <?= $a['nama_kelas'] ?> - <?= $a['nama_mapel'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada absensi yang Anda ajukan yang menunggu persetujuan.</p>
    <?php endif; ?>

    <h3>✏️ Absensi Perlu Direvisi</h3>
    <?php if (!empty($absensiDitolak)): ?>
        <ul>
            <?php foreach ($absensiDitolak as $a): ?>
                <li>
                    <?= htmlspecialchars($a['tanggal']) ?> - <?= htmlspecialchars($a['nama_kelas']) ?> - <?= htmlspecialchars($a['nama_mapel']) ?>
                    |
                    <a href="?page=edit_absensi&id=<?= $a['id_absensi'] ?>">✏️ Edit</a>
                    |
                    <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>">Lihat</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada absensi yang ditolak.</p>
    <?php endif; ?>

    <?php if ($isWaliKelas): ?>
        <hr>
        <h3>📌 Absensi Menunggu Persetujuan Wali Kelas</h3>
        <?php if (!empty($absensiPendingWali)): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($absensiPendingWali as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['tanggal']) ?></td>
                            <td><?= htmlspecialchars($a['nama_kelas']) ?></td>
                            <td><?= htmlspecialchars($a['nama_mapel']) ?></td>
                            <td><?= htmlspecialchars($a['status_wali_kelas']) ?></td>
                            <td>
                                <form method="POST" action="?page=persetujuan_absensi" style="display:inline;">
                                    <input type="hidden" name="id_absensi" value="<?= $a['id_absensi'] ?>">
                                    <button type="submit" name="aksi" value="setuju">Setujui</button>
                                    <button type="submit" name="aksi" value="tolak">Tolak</button>
                                </form>
                                |
                                <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>">Lihat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><em>Tidak ada absensi yang menunggu persetujuan.</em></p>
        <?php endif; ?>

        <hr>
        <h3>Administrasi Wali Kelas</h3>
        <p><a href="?page=rekap_excel_style">📅 Rekap Kehadiran Bulanan</a></p>
        <p><a href="?page=rekap_kehadiran_harian">📘 Lihat Rekap Kehadiran Harian</a></p>
    <?php endif; ?>

    <hr>
    <h3>Administrasi Guru Mapel</h3>
    <p><a href="?page=riwayat_absensi">📄 Lihat Riwayat Absensi yang Diajukan</a></p>
    <p><a href="?page=rekap_bulanan_guru">📊 Lihat Rekap Absensi Bulanan Saya</a></p>
    <hr>
</body>

</html>