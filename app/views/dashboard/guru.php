<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$namaGuru = $_SESSION['user']['nama'] ?? $_SESSION['user']['email'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link rel="stylesheet" href="assets/css/dashboard_guru.css"> <!-- GANTI path jika perlu -->
</head>

<body>

    <h2>Dashboard Guru</h2>

    <div class="card">
        <p>Halo, <strong><?= htmlspecialchars($namaGuru) ?></strong> 👋</p>

        <?php if ($isWaliKelas): ?>
            <p>Anda adalah wali kelas dari:</p>
            <ul>
                <?php foreach ($kelasWali as $k): ?>
                    <li><?= htmlspecialchars($k['nama_kelas']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><em>Anda bukan wali kelas.</em></p>
        <?php endif; ?>
    </div>



    <div class="card">
        <h3>📅 Jadwal Mengajar</h3>

        <?php if (!empty($jadwal)): ?>
            <div style="overflow-x: auto;">
                <table class="table-absensi" style="min-width: 600px;">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $j): ?>
                            <tr>
                                <td><?= htmlspecialchars($j['hari']) ?></td>
                                <td><?= htmlspecialchars($j['jam_mulai']) ?> - <?= htmlspecialchars($j['jam_selesai']) ?></td>
                                <td><?= htmlspecialchars($j['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($j['nama_mapel']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p><em>Belum ada jadwal mengajar.</em></p>
        <?php endif; ?>
    </div>





    <!-- <div class="card">
        <h3>📚 Mata Pelajaran Diampu</h3>
        <ul>
            <?php if (!empty($mapel)): ?>
                <?php foreach ($mapel as $m): ?>
                    <li><?= htmlspecialchars($m['nama_mapel']) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li><em>Belum ada mata pelajaran.</em></li>
            <?php endif; ?>
        </ul>
    </div> -->






    <div class="card">
        <h3>📝 Form Absensi</h3>
        <form method="GET" class="form-inline">
            <input type="hidden" name="page" value="absensi">
            <label>Pilih Kelas:
                <select name="kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach ($kelasList as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>Pilih Mapel:
                <select name="mapel" required>
                    <option value="">-- Pilih Mapel --</option>
                    <?php foreach ($mapel as $m): ?>
                        <option value="<?= $m['id_mapel'] ?? '' ?>"><?= htmlspecialchars($m['nama_mapel'] ?? '-') ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <button type="submit">Isi Absensi</button>
        </form>
    </div>

    <div class="card">
        <h3>⏳ Absensi Menunggu Persetujuan</h3>

        <?php if (!empty($absensiPendingGuru)): ?>
            <div class="table-responsive">
                <table class="table-absensi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absensiPendingGuru as $a): ?>
                            <tr>
                                <td><?= htmlspecialchars($a['tanggal']) ?></td>
                                <td><?= htmlspecialchars($a['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($a['nama_mapel']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p><em>Tidak ada absensi yang Anda ajukan yang menunggu persetujuan.</em></p>
        <?php endif; ?>
    </div>

    <!-- ❌ ABSENSI DITOLAK / PERLU DIREVISI -->
    <div class="card">
        <h3>❌ Absensi Perlu Direvisi</h3>

        <?php if (!empty($absensiDitolak)): ?>
            <div class="table-responsive">
                <table class="table-absensi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absensiDitolak as $a): ?>
                            <tr>
                                <td><?= htmlspecialchars($a['tanggal']) ?></td>
                                <td><?= htmlspecialchars($a['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($a['nama_mapel']) ?></td>
                                <td>
                                    <a href="?page=edit_absensi&id=<?= $a['id_absensi'] ?>" class="btn-link">✏️ Edit</a> |
                                    <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>" class="btn-link">Lihat</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p><em>Tidak ada absensi yang ditolak.</em></p>
        <?php endif; ?>
    </div>

    <?php if ($isWaliKelas): ?>
        <div class="card">
            <h3>📌 Persetujuan Absensi Wali Kelas</h3>

            <?php if (!empty($absensiPendingWali)): ?>
                <div class="table-responsive">
                    <table class="table-absensi">
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
                                            <button type="submit" name="aksi" value="setuju" class="btn-accept"
                                                onclick="return confirm('Yakin ingin menyetujui absensi ini?')">✅</button>
                                            <button type="submit" name="aksi" value="tolak" class="btn-reject"
                                                onclick="return confirm('Yakin ingin menolak absensi ini?')">❌</button>
                                        </form>

                                        <a href="?page=detail_absensi&id=<?= $a['id_absensi'] ?>" class="btn-link">Lihat</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p><em>Tidak ada absensi yang menunggu persetujuan.</em></p>
            <?php endif; ?>
        </div>


        <div class="card">
            <h3>📂 Administrasi Wali Kelas</h3>
            <p><a href="?page=rekap_excel_style">📅 Rekap Kehadiran Bulanan</a></p>
            <p><a href="?page=rekap_kehadiran_harian">📘 Rekap Kehadiran Harian</a></p>
        </div>
    <?php endif; ?>

    <div class="card">
        <h3>📁 Administrasi Guru Mapel</h3>
        <p><a href="?page=riwayat_absensi">📄 Riwayat Absensi Diajukan</a></p>
        <p><a href="?page=rekap_bulanan_guru">📊 Rekap Absensi Bulanan</a></p>
    </div>



    <div style="text-align:center; margin-top:1rem;">
        <a href="?page=ganti_password">🔑 Ganti Password</a>
    </div>



    <div style="text-align:center; margin-top:2rem;">
        <a href="?page=logout">🔓 Logout</a>
    </div>

</body>

</html>