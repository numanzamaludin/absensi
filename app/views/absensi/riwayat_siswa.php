<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Diajukan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/riwayat_absensi.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>📄 Riwayat Absensi yang Diajukan</h2>

            <div class="button-top">
                <a href="?page=dashboard" class="btn-back">← Kembali ke Dashboard</a>
            </div>

            <?php if (empty($riwayat)): ?>
                <p><em>Tidak ada data absensi.</em></p>
            <?php else: ?>
                <div class="sort-controls">
                    Urutkan Kelas:
                    <button onclick="sortTableAZ()">🔼 A-Z</button>
                    <button onclick="sortTableZA()">🔽 Z-A</button>
                </div>

                <div class="table-wrapper">
                    <table id="absensiTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat as $abs): ?>
                                <tr>
                                    <td><?= htmlspecialchars($abs['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($abs['nama_kelas']) ?></td>
                                    <td><?= htmlspecialchars($abs['nama_mapel']) ?></td>
                                    <td><?= htmlspecialchars($abs['status_wali_kelas']) ?></td>
                                    <td><a href="?page=detail_absensi&id=<?= $abs['id_absensi'] ?>" class="btn-detail">🔍</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function sortTableAZ() {
            sortTable(true);
        }

        function sortTableZA() {
            sortTable(false);
        }

        function sortTable(asc = true) {
            const table = document.getElementById('absensiTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const valA = a.children[1].textContent.trim().toLowerCase();
                const valB = b.children[1].textContent.trim().toLowerCase();
                return asc ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });

            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>

</html>