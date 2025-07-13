<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Absensi</title>
    <link rel="stylesheet" href="assets/css/detail_absensi.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="container">
        <div class="card">
            <h2>📋 Detail Absensi</h2>
            <div class="button-wrapper">
                <a href="?page=dashboard" class="btn-cancel">← Kembali ke Dashboard</a>
            </div>
            <div class="info">
                <p><strong>Tanggal:</strong> <?= htmlspecialchars($absensi['tanggal']) ?></p>
                <p><strong>Kelas:</strong> <?= htmlspecialchars($absensi['nama_kelas']) ?></p>
                <p><strong>Mapel:</strong> <?= htmlspecialchars($absensi['nama_mapel']) ?></p>
                <p><strong>Status Wali Kelas:</strong> <?= htmlspecialchars($absensi['status_wali_kelas']) ?></p>
            </div>

            <h3>👨‍🎓 Data Siswa</h3>

            <div class="sort-controls">
                Urutkan:
                <button type="button" onclick="sortTableAZ()">🔼 A-Z</button>
                <button type="button" onclick="sortTableZA()">🔽 Z-A</button>
            </div>

            <div class="table-wrapper">
                <table class="responsive-table" id="siswaTable">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th> <!-- Tambahan kolom -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($siswa as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['nama_siswa']) ?></td>
                                <td><?= ucfirst($s['status_kehadiran']) ?></td>
                                <td><?= !empty($s['keterangan']) ? htmlspecialchars($s['keterangan']) : '-' ?></td> <!-- Keterangan -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>


    </div>
    </div>

    <script>
        function sortTableAZ() {
            sortTable(true);
        }

        function sortTableZA() {
            sortTable(false);
        }

        function sortTable(ascending = true) {
            const table = document.getElementById('siswaTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const nameA = a.children[0].textContent.toLowerCase();
                const nameB = b.children[0].textContent.toLowerCase();
                return ascending ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>

</html>