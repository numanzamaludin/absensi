<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Bulanan per Mapel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/rekap_bulanan_mapel.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>📊 Rekap Absensi Bulanan per Mapel</h2>

            <div class="btn-top">
                <a href="?page=dashboard" class="btn-back">← Kembali ke Dashboard</a>
            </div>

            <form method="POST" class="filter-form">
                <label>Bulan:
                    <select name="bulan">
                        <?php
                        $bulanList = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                        foreach ($bulanList as $num => $nama):
                            $selected = ($num == $bulan) ? 'selected' : '';
                            echo "<option value=\"$num\" $selected>$nama</option>";
                        endforeach;
                        ?>
                    </select>
                </label>
                <label>Tahun:
                    <select name="tahun">
                        <?php
                        $tahunSekarang = date('Y');
                        for ($t = $tahunSekarang; $t >= $tahunSekarang - 5; $t--):
                            $selected = ($t == $tahun) ? 'selected' : '';
                            echo "<option value=\"$t\" $selected>$t</option>";
                        endfor;
                        ?>
                    </select>
                </label>
                <button type="submit" class="btn-filter">Tampilkan</button>
            </form>

            <div class="sort-controls">
                Urutkan berdasarkan Kelas:
                <button type="button" onclick="sortTable(true)">🔼 A-Z</button>
                <button type="button" onclick="sortTable(false)">🔽 Z-A</button>
            </div>

            <?php if (!empty($rekap)): ?>
                <div class="table-wrapper">
                    <table id="rekapTable">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alpa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r['nama_kelas']) ?></td>
                                    <td><?= htmlspecialchars($r['nama_mapel']) ?></td>
                                    <td><?= $r['hadir'] ?></td>
                                    <td><?= $r['izin'] ?></td>
                                    <td><?= $r['sakit'] ?></td>
                                    <td><?= $r['alpa'] ?></td>
                                    <td>
                                        <?php if (!empty($r['id_kelas']) && !empty($r['id_mapel'])): ?>
                                            <a href="?page=detail_rekap_siswa&id_kelas=<?= $r['id_kelas'] ?>&id_mapel=<?= $r['id_mapel'] ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>">🔍 Detail</a>
                                        <?php else: ?>
                                            <em>Data tidak lengkap</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p><em>Tidak ada data absensi untuk bulan ini.</em></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function sortTable(asc = true) {
            const table = document.getElementById('rekapTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const aText = a.children[0].textContent.trim().toLowerCase();
                const bText = b.children[0].textContent.trim().toLowerCase();
                return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
            });

            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>

</html>