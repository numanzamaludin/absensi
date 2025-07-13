<h2>Rekap Absensi Bulanan</h2>

<!-- 🔽 Form Filter Bulan dan Tahun -->
<form method="GET" action="">
    <input type="hidden" name="page" value="rekap">

    <label for="bulan">Bulan:</label>
    <select name="bulan" id="bulan">
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>" <?= ($i == $bulan) ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
            </option>
        <?php endfor; ?>
    </select>

    <label for="tahun">Tahun:</label>
    <select name="tahun" id="tahun">
        <?php for ($t = date('Y'); $t >= date('Y') - 5; $t--): ?>
            <option value="<?= $t ?>" <?= ($t == $tahun) ? 'selected' : '' ?>>
                <?= $t ?>
            </option>
        <?php endfor; ?>
    </select>

    <button type="submit">Tampilkan</button>
</form>

<br>

<!-- 🔁 Tampilkan Rekap per Kelas -->
<?php foreach ($rekapData as $kelas): ?>
    <h3>Kelas: <?= htmlspecialchars($kelas['nama_kelas']) ?></h3>

    <?php
    // Kelompokkan data berdasarkan mata pelajaran
    $grouped = [];
    foreach ($kelas['data'] as $row) {
        $grouped[$row['nama_mapel']][] = $row;
    }
    ?>

    <!-- 🔁 Tampilkan Rekap per Mata Pelajaran -->
    <?php foreach ($grouped as $mapel => $rows): ?>
        <h4>Mata Pelajaran: <?= htmlspecialchars($mapel) ?></h4>
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nama_siswa']) ?></td>
                        <td><?= $r['hadir'] ?></td>
                        <td><?= $r['izin'] ?></td>
                        <td><?= $r['sakit'] ?></td>
                        <td><?= $r['alpa'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
    <?php endforeach; ?>
<?php endforeach; ?>