<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Absensi</title>
    <link rel="stylesheet" href="assets/css/form_absensi.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>📋 Form Absensi</h2>


            <div class="info">
                <p><strong>Kelas:</strong> <?= htmlspecialchars($kelasTerpilih['nama_kelas'] ?? '-') ?></p>
                <p><strong>Mata Pelajaran:</strong> <?= htmlspecialchars($mapel['nama_mapel'] ?? '-') ?></p>
            </div>

            <?php if (empty($siswa)): ?>
                <p class="warning">⚠️ Tidak ada siswa di kelas ini.</p>
            <?php else: ?>
                <form method="POST" action="?page=simpan_absensi" onsubmit="return konfirmasiSimpan();">
                    <input type="hidden" name="id_kelas" value="<?= htmlspecialchars($id_kelas) ?>">
                    <input type="hidden" name="id_guru_mapel" value="<?= htmlspecialchars($id_guru_mapel) ?>">

                    <div class="table-wrapper">
                        <div class="sort-control">
                            <label>Urutkan Nama:</label>
                            <button type="button" onclick="sortTableAZ()">🔼 A-Z</button>
                            <button type="button" onclick="sortTableZA()">🔽 Z-A</button>
                        </div>
                        <table class="absensi-table">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Kehadiran</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($siswa as $s): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($s['nama_siswa']) ?></td>
                                        <td>
                                            <select name="absensi[<?= $s['id_siswa'] ?>]">
                                                <option value="hadir">Hadir</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alpa">Alpa</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan[<?= $s['id_siswa'] ?>]" placeholder="Opsional">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="submit-wrapper dual-buttons">
                        <button type="submit" class="submit-btn">💾 Simpan Perubahan</button>
                        <a href="?page=dashboard" class="cancel-btn">❌ Batal</a>
                    </div>

                </form>
            <?php endif; ?>
        </div>
    </div>


    <script>
        function konfirmasiSimpan() {
            return confirm("Yakin ingin menyimpan absensi ini?\nKlik OK untuk melanjutkan, atau Cancel untuk periksa ulang.");
        }

        function sortTableAZ() {
            sortTable(true);
        }

        function sortTableZA() {
            sortTable(false);
        }

        function sortTable(ascending = true) {
            const tbody = document.querySelector(".absensi-table tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            rows.sort((a, b) => {
                const nameA = a.children[0].textContent.toLowerCase();
                const nameB = b.children[0].textContent.toLowerCase();
                if (nameA < nameB) return ascending ? -1 : 1;
                if (nameA > nameB) return ascending ? 1 : -1;
                return 0;
            });

            // Re-append rows
            rows.forEach(row => tbody.appendChild(row));
        }
    </script>




    <script>
        function konfirmasiSimpan() {
            return confirm("Yakin ingin menyimpan absensi ini?\nKlik OK untuk melanjutkan, atau Cancel untuk periksa ulang.");
        }
    </script>
</body>

</html>