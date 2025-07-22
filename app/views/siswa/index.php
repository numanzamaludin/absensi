<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <li><a href="?page=import_siswa">Import Siswa</a></li>
<?php endif; ?>

<h2>Data Siswa</h2>
<a href="?page=siswa_tambah">+ Tambah Siswa</a>
<br><br>

<label for="filterKelas">Filter Kelas:</label>
<select id="filterKelas">
    <option value="">Semua</option>
    <?php
    // Ambil daftar kelas unik dari data
    $kelasList = array_unique(array_map(fn($s) => $s['nama_kelas'], $data));
    sort($kelasList);
    foreach ($kelasList as $kelas) {
        echo "<option value=\"" . htmlspecialchars($kelas) . "\">" . htmlspecialchars($kelas) . "</option>";
    }
    ?>
</select>

<br><br>

<table id="siswaTable" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIS</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php $no = 1;
            foreach ($data as $siswa): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                    <td><?= htmlspecialchars($siswa['nis']) ?></td>
                    <td><?= htmlspecialchars($siswa['email']) ?></td>
                    <td><?= htmlspecialchars($siswa['nama_kelas']) ?></td>
                    <td>
                        <a href="?page=siswa_edit&id=<?= $siswa['id_siswa'] ?>">Edit</a> |
                        <a href="?page=siswa_hapus&id=<?= $siswa['id_siswa'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Tidak ada data.</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

<!-- DataTables + Export Excel Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        const table = $('#siswaTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        // Filter kelas
        $('#filterKelas').on('change', function() {
            const val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(4).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });
</script>