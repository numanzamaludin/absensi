<h2>📅 Rekap Kehadiran Bulanan (Excel Style)</h2>
<a href="?page=dashboard">← Kembali ke Dashboard</a>
<!-- 🔎 INFORMASI -->
<p>
    <strong>Kelas:</strong> <?= htmlspecialchars($nama_kelas) ?><br>
    <strong>Wali Kelas:</strong> <?= htmlspecialchars($wali_kelas) ?><br>
</p>

<!-- Tombol Ekspor -->
<div style="margin: 10px 0;">
    <a href="index.php?page=export_rekap_excel&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download Excel</a> |
    <a href="index.php?page=export_rekap_csv&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download CSV</a> |
    <a href="index.php?page=export_rekap_pdf&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="button">📥 Download PDF</a>
</div>

<!-- 🔽 FORM FILTER -->
<form id="filterForm">
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

    <button type="submit">Tampilkan</button>
</form>

<hr>

<div id="rekapResult">
    <!-- Isi awal tabel akan dimuat di sini -->
    <?= include __DIR__ . '/_partial_table.php'; ?>
</div>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        fetch(`index.php?page=ajax_rekap_excel&bulan=${bulan}&tahun=${tahun}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('rekapResult').innerHTML = html;
            })
            .catch(err => {
                alert('Gagal memuat data');
                console.error(err);
            });
    });
</script>