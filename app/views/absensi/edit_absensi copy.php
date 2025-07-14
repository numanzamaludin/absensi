<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/edit_absensi.css"> <!-- Sesuaikan path -->
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>✏️ Edit Absensi</h2>

            <form method="POST" action="?page=proses_edit_absensi" onsubmit="return konfirmasiKirim();">
                <input type="hidden" name="id_absensi" value="<?= htmlspecialchars($absensi['id_absensi']) ?>">

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absensiDetail as $siswa): ?>
                                <tr>
                                    <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                    <td>
                                        <select name="kehadiran[<?= $siswa['id_siswa'] ?>]">
                                            <option value="hadir" <?= $siswa['status_kehadiran'] === 'hadir' ? 'selected' : '' ?>>Hadir</option>
                                            <option value="izin" <?= $siswa['status_kehadiran'] === 'izin' ? 'selected' : '' ?>>Izin</option>
                                            <option value="sakit" <?= $siswa['status_kehadiran'] === 'sakit' ? 'selected' : '' ?>>Sakit</option>
                                            <option value="alfa" <?= $siswa['status_kehadiran'] === 'alfa' ? 'selected' : '' ?>>Alfa</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="keterangan[<?= $siswa['id_siswa'] ?>]" placeholder="Opsional" value="<?= htmlspecialchars($siswa['keterangan'] ?? '') ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
                    <a href="?page=dashboard" class="btn-secondary">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function konfirmasiKirim() {
            return confirm("Yakin ingin mengirim absensi hasil revisi ke wali kelas?\nKlik OK untuk melanjutkan atau Cancel untuk periksa ulang.");
        }
    </script>
</body>

</html>