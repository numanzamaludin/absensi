<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Harian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/rekap_harian.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>📘 Rekap Kehadiran Harian</h2>

            <a href="?page=dashboard" class="btn-back">← Kembali ke Dashboard</a>

            <!-- 🔍 FILTER -->
            <form id="filterFormHarian" class="filter-form">
                <div class="form-group">
                    <?php
                    $tanggalDipilih = $_GET['tanggal'] ?? date('j');
                    $bulanDipilih   = $_GET['bulan'] ?? date('n');
                    $tahunDipilih   = $_GET['tahun'] ?? date('Y');
                    ?>

                    <label>Tanggal:

                        <select name="tanggal" id="tanggal">
                            <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= $d ?>" <?= ($d == $tanggalDipilih ? 'selected' : '') ?>><?= $d ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>

                    <label>Bulan:
                        <select name="bulan" id="bulan">
                            <?php for ($b = 1; $b <= 12; $b++): ?>
                                <option value="<?= $b ?>" <?= ($b == $bulanDipilih ? 'selected' : '') ?>><?= date('F', mktime(0, 0, 0, $b, 1)) ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>

                    <label>Tahun:
                        <select name="tahun" id="tahun">
                            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?= $y ?>" <?= ($y == $tahunDipilih ? 'selected' : '') ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                </div>
                <button type="submit" class="btn-primary">Tampilkan</button>
            </form>

            <!-- 🔽 SORT -->
            <div class="sort-buttons">
                Urutkan Nama:
                <button type="button" onclick="sortTable(true)">🔼 A-Z</button>
                <button type="button" onclick="sortTable(false)">🔽 Z-A</button>
            </div>

            <!-- 🔽 EKSPOR -->
            <div class="export-buttons">
                <a id="btn-xls" class="btn">📥 Excel</a>
                <a id="btn-csv" class="btn">📥 CSV</a>
                <a id="btn-pdf" class="btn">📥 PDF</a>
            </div>

            <!-- 🔽 HASIL TABEL -->
            <div id="rekapHarianResult" class="table-wrapper">
                <?php include __DIR__ . '/_partial_rekap_harian_table.php'; ?>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('filterFormHarian');
        const tanggal = document.getElementById('tanggal');
        const bulan = document.getElementById('bulan');
        const tahun = document.getElementById('tahun');
        const result = document.getElementById('rekapHarianResult');
        const btnXls = document.getElementById('btn-xls');
        const btnCsv = document.getElementById('btn-csv');
        const btnPdf = document.getElementById('btn-pdf');

        function updateExportLinks() {
            const t = tanggal.value;
            const b = bulan.value;
            const y = tahun.value;

            btnXls.href = `index.php?page=export_harian&format=xls&tanggal=${t}&bulan=${b}&tahun=${y}`;
            btnCsv.href = `index.php?page=export_harian&format=csv&tanggal=${t}&bulan=${b}&tahun=${y}`;
            btnPdf.href = `index.php?page=export_harian&format=pdf&tanggal=${t}&bulan=${b}&tahun=${y}`;
        }

        function sortTable(asc = true) {
            const table = document.querySelector("#rekapHarianResult table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            rows.sort((a, b) => {
                const nameA = a.querySelector("td").innerText.toLowerCase();
                const nameB = b.querySelector("td").innerText.toLowerCase();
                return asc ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            rows.forEach(row => tbody.appendChild(row));
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            updateExportLinks();

            fetch(`index.php?page=ajax_rekap_harian&tanggal=${tanggal.value}&bulan=${bulan.value}&tahun=${tahun.value}`)
                .then(res => res.text())
                .then(html => {
                    result.innerHTML = html;
                })
                .catch(() => {
                    alert("Gagal memuat data");
                });
        });

        updateExportLinks();
    </script>
</body>

</html>