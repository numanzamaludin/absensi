<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Bulanan Guru</title>
</head>

<body>

    <h2>Riwayat Absensi Bulanan Guru</h2>

    <label for="bulan">Bulan:</label>
    <select id="bulan">
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>" <?= $i == date('n') ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
        <?php endfor; ?>
    </select>

    <label for="tahun">Tahun:</label>
    <select id="tahun">
        <?php for ($y = 2022; $y <= date('Y'); $y++): ?>
            <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

    <div id="tabel-absensi">
        <!-- Tabel awal -->
        <?php if (!empty($riwayat)) : ?>
            <?php require_once __DIR__ . '/../../helpers/render_helper.php'; ?>

            <?= renderTable($riwayat) ?>
        <?php else : ?>
            <p>Tidak ada data absensi.</p>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('bulan').addEventListener('change', fetchData);
        document.getElementById('tahun').addEventListener('change', fetchData);

        function fetchData() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            fetch(`index.php?page=ajax_riwayat_bulanan_guru&bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('tabel-absensi').innerHTML = html;
                });
        }
    </script>

</body>

</html>