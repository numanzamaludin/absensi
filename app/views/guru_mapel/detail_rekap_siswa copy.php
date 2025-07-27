<h2>📘 Detail Absensi Per Mata Pelajaran</h2>
<a href="?page=rekap_bulanan_guru">← Kembali ke Rekap Bulanan</a>

<p>
    <strong>Kelas:</strong> <?= htmlspecialchars($info['nama_kelas']) ?><br>
    <strong>Mata Pelajaran:</strong> <?= htmlspecialchars($info['nama_mapel']) ?><br>
    <strong>Wali Kelas:</strong> <?= htmlspecialchars($info['wali_kelas']) ?><br>
    <strong>Bulan:</strong> <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?><br>
    <strong>Tahun:</strong> <?= $tahun ?>
</p>
<!-- 🔽 Tombol Download -->
<div style="margin: 10px 0;">
    <a href="index.php?page=export_detail_mapel&format=xls&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download Excel</a>
    |
    <a href="index.php?page=export_detail_mapel&format=csv&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download CSV</a>
    |
    <a href="index.php?page=export_detail_mapel&format=pdf&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download PDF</a>
</div>

<?php if (empty($data)): ?>
    <p><em>Tidak ada data absensi.</em></p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <?php
                $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                for ($d = 1; $d <= $jumlahHari; $d++):
                    echo "<th>$d</th>";
                endfor;
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $i => $siswa): ?>
                <?php if (!empty(array_filter($siswa['kehadiran']))): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <?php for ($d = 1; $d <= $jumlahHari; $d++): ?>
                            <td><?= $siswa['kehadiran'][$d] ?? '-' ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>