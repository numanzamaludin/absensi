<h2>📘 Rekap Kehadiran Harian Siswa - Format Excel</h2>
<a href="?page=dashboard">← Kembali ke Dashboard</a>

<?php
// Default nilai filter jika belum dikirim (GET)
$tanggalDipilih = $_GET['tanggal'] ?? date('j');
$bulanDipilih   = $_GET['bulan'] ?? date('n');
$tahunDipilih   = $_GET['tahun'] ?? date('Y');
?>

<!-- 🔍 FILTER -->
<form id="filterFormHarian">
    <input type="hidden" name="page" value="rekap_kehadiran_harian">

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

    <button type="submit">Tampilkan</button>
</form>

<!-- 🔽 Tombol Ekspor -->
<div style="margin: 10px 0;">
    <a id="btn-xls" class="button">📥 Download Excel</a> |
    <a id="btn-csv" class="button">📥 Download CSV</a> |
    <a id="btn-pdf" class="button">📥 Download PDF</a>
</div>

<!-- 🔽 DATA -->
<div id="rekapHarianResult">
    <?php include __DIR__ . '/_partial_rekap_harian_table.php'; ?>
</div>

<!-- 🧠 JS -->
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

    updateExportLinks();

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const t = tanggal.value;
        const b = bulan.value;
        const y = tahun.value;

        updateExportLinks();

        fetch(`index.php?page=ajax_rekap_harian&tanggal=${t}&bulan=${b}&tahun=${y}`)
            .then(res => res.text())
            .then(html => {
                result.innerHTML = html;
            })
            .catch(err => {
                alert('Gagal memuat data');
                console.error(err);
            });
    });
</script>