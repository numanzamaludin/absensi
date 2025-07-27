<?php
function renderTable($riwayat)
{
    ob_start();
?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Metode</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($riwayat as $absen): ?>
                <tr>
                    <td><?= htmlspecialchars($absen['tanggal']) ?></td>
                    <td><?= htmlspecialchars($absen['waktu']) ?></td>
                    <td><?= htmlspecialchars($absen['nama_kelas']) ?></td>
                    <td><?= htmlspecialchars($absen['nama_mapel']) ?></td>
                    <td><?= htmlspecialchars($absen['jam_mulai']) ?></td>
                    <td><?= htmlspecialchars($absen['jam_selesai']) ?></td>
                    <td><?= htmlspecialchars($absen['metode']) ?></td>
                    <td><?= htmlspecialchars($absen['lokasi']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
    return ob_get_clean();
}
