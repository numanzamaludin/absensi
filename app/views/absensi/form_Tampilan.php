<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Absensi</title>
    <link rel="stylesheet" href="form_absensi.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="container">
        <div class="card">
            <h2>📝 Form Absensi</h2>

            <a href="?page=dashboard" class="back-link">← Kembali ke Dashboard</a>

            <div class="info">
                <p><strong>Kelas:</strong> <?= htmlspecialchars($kelasTerpilih['nama_kelas'] ?? '-') ?></p>
                <p><strong>Mapel:</strong> <?= htmlspecialchars($mapel['nama_mapel'] ?? '-') ?></p>
            </div>

            <?php if (empty($siswa)): ?>
                <div class="alert">⚠️ Tidak ada siswa di kelas ini.</div>
            <?php else: ?>
                <form method="POST" action="?page=simpan_absensi">
                    <input type="hidden" name="id_kelas" value="<?= htmlspecialchars($id_kelas) ?>">
                    <input type="hidden" name="id_guru_mapel" value="<?= htmlspecialchars($id_guru_mapel) ?>">

                    <div class="form-table">
                        <?php foreach ($siswa as $s): ?>
                            <div class="form-row">
                                <label><?= htmlspecialchars($s['nama_siswa']) ?></label>
                                <select name="absensi[<?= $s['id_siswa'] ?>]">
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpa">Alpa</option>
                                </select>
                                <input type="text" name="keterangan[<?= $s['id_siswa'] ?>]" placeholder="Keterangan (Opsional)">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-primary">💾 Simpan Absensi</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>