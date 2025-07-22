<h2>Daftar Guru & Mata Pelajaran</h2>

<a href="?page=guru_mapel_tambah">+ Tambah Guru Mapel</a>
<br><br>

<!-- Filter Kelas -->
<label for="filterKelas">Filter Kelas:</label>
<select id="filterKelas">
    <option value="">Semua</option>
    <?php
    // Ambil daftar kelas unik dari data
    $kelasList = array_unique(array_map(fn($d) => $d['nama_kelas'], $data));
    sort($kelasList);
    foreach ($kelasList as $kelas) {
        echo "<option value=\"" . htmlspecialchars($kelas) . "\">" . htmlspecialchars($kelas) . "</option>";
    }
    ?>
</select>

<br><br>

<table id="guruMapelTable" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Guru</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                <td>
                    <a href="?page=guru_mapel_edit&id=<?= $row['id_guru_mapel'] ?>">Edit</a> |
                    <a href="?page=guru_mapel_hapus&id=<?= $row['id_guru_mapel'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- DataTables + Export Excel -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        const table = $('#guruMapelTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        // Filter kelas
        $('#filterKelas').on('change', function() {
            const val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(3).search(val ? '^' + val + '$' : '', true, false).draw(); // Kolom ke-4 = index 3
        });
    });
</script>