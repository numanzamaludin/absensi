<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Absensi Per Mapel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/detail_mapel.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>📘 Detail Absensi Per Mata Pelajaran</h2>

            <div class="top-actions">
                <a href="?page=rekap_bulanan_guru" class="btn-back">← Kembali ke Rekap Bulanan</a>
            </div>

            <div class="info">
                <p><strong>Kelas:</strong> <?= htmlspecialchars($info['nama_kelas']) ?></p>
                <p><strong>Mata Pelajaran:</strong> <?= htmlspecialchars($info['nama_mapel']) ?></p>
                <p><strong>Wali Kelas:</strong> <?= htmlspecialchars($info['wali_kelas']) ?></p>
                <p><strong>Bulan:</strong> <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?></p>
                <p><strong>Tahun:</strong> <?= $tahun ?></p>
            </div>

            <div class="export-buttons">
                <a href="index.php?page=export_detail_mapel&format=xls&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 Excel</a>
                <a href="index.php?page=export_detail_mapel&format=csv&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 CSV</a>
                <a href="index.php?page=export_detail_mapel&format=pdf&id_kelas=<?= $id_kelas ?>&id_mapel=<?= $id_mapel ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 PDF</a>
            </div>

            <div class="sort-buttons">
                Urutkan Nama:
                <button onclick="sortTable(true)">🔼 A-Z</button>
                <button onclick="sortTable(false)">🔽 Z-A</button>
            </div>

            <?php if (empty($data)): ?>
                <p><em>Tidak ada data absensi.</em></p>
            <?php else: ?>
                <div class="table-wrapper">
                    <table id="absensiTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th class="sticky-col">Nama Siswa</th>
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
                                        <td class="sticky-col"><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                        <?php for ($d = 1; $d <= $jumlahHari; $d++): ?>
                                            <td><?= $siswa['kehadiran'][$d] ?? '-' ?></td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function sortTable(asc = true) {
            const table = document.getElementById('absensiTable');
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            rows.sort((a, b) => {
                const nameA = a.children[2].innerText.toLowerCase(); // Kolom ke-2 (Nama Siswa)
                const nameB = b.children[2].innerText.toLowerCase();
                return asc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>

</html>