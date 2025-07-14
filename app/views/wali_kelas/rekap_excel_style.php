<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran Bulanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/rekap_bulanan.css">
</head>

<body>
    <div class="container">
        <div class="card">



            <h2>📅 Rekap Kehadiran Bulanan</h2>
            <!-- 🔙 Tombol Kembali -->
            <div class="back-button">
                <a href="?page=dashboard" class="btn-secondary">← Kembali ke Dashboard</a>
            </div>
            <div class="info">
                <p><strong>Kelas:</strong> <?= htmlspecialchars($nama_kelas) ?></p>
                <p><strong>Wali Kelas:</strong> <?= htmlspecialchars($wali_kelas) ?></p>
            </div>

            <div class="export-buttons">
                <a href="index.php?page=export_rekap_excel&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 Excel</a>
                <a href="index.php?page=export_rekap_csv&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 CSV</a>
                <a href="index.php?page=export_rekap_pdf&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn">📥 PDF</a>
            </div>

            <form id="filterForm" class="filter-form">
                <label>Bulan:
                    <select name="bulan" id="bulan">
                        <?php for ($b = 1; $b <= 12; $b++): ?>
                            <option value="<?= $b ?>" <?= ($b == $bulan) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $b, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>
                <label>Tahun:
                    <select name="tahun" id="tahun">
                        <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                            <option value="<?= $y ?>" <?= ($y == $tahun) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </label>
                <button type="submit" class="btn-small">Tampilkan</button>
            </form>

            <div class="sort-buttons">
                Urutkan Nama:
                <button onclick="sortTable(true)">🔼 A-Z</button>
                <button onclick="sortTable(false)">🔽 Z-A</button>
            </div>

            <div id="rekapResult" class="table-wrapper">
                <?= include __DIR__ . '/_partial_table.php'; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            fetch(`index.php?page=ajax_rekap_excel&bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('rekapResult').innerHTML = html;
                })
                .catch(() => {
                    alert('Gagal memuat data.');
                });
        });

        function sortTable(asc = true) {
            const table = document.querySelector("#rekapResult table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            rows.sort((a, b) => {
                const nameA = a.children[1].innerText.toLowerCase();
                const nameB = b.children[1].innerText.toLowerCase();
                return asc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            rows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>

</html>