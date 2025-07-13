<h3>Absensi Menunggu Persetujuan</h3>

<?php if (!empty($absensiPending)): ?>
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
            <?php foreach ($absensiPending as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['tanggal']) ?></td>
                    <td><?= htmlspecialchars($a['nama_kelas']) ?></td>
                    <td><?= htmlspecialchars($a['nama_mapel']) ?></td>
                    <td><?= htmlspecialchars($a['status_wali_kelas']) ?></td>
                    <td>
                        <form method="POST" action="?page=absensi_persetujuan">
                            <input type="hidden" name="id_absensi" value="<?= $a['id_absensi'] ?>">
                            <button type="submit" name="aksi" value="setuju">✔️ Setujui</button>
                            <button type="submit" name="aksi" value="tolak">❌ Tolak</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p><em>Tidak ada absensi yang menunggu persetujuan.</em></p>
<?php endif; ?>
