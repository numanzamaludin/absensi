<h2>Riwayat Absensi Harian</h2>

<?php if (!empty($riwayat)): ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Metode</th>
                <th>Lokasi</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($riwayat as $data): ?>
                <tr>
                    <td><?= $data['tanggal'] ?></td>
                    <td><?= $data['waktu'] ?></td>
                    <td><?= $data['metode'] ?></td>
                    <td><?= $data['lokasi'] ?></td>
                    <td><?= $data['nama_kelas'] ?></td>
                    <td><?= $data['nama_mapel'] ?></td>
                    <td><?= $data['jam_mulai'] ?></td>
                    <td><?= $data['jam_selesai'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Tidak ada data absensi untuk hari ini.</p>
<?php endif; ?>