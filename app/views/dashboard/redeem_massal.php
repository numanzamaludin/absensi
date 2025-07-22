<h2>Redeem Email Massal</h2>

<a href="?page=admin_redeem_create">+ Tambah Akun</a>
<br><br>

<form method="post" enctype="multipart/form-data" action="?page=admin_redeem_import">
    <input type="file" name="file" required>
    <button type="submit">Import Excel</button>
</form>

<br>
<a href="?page=admin_redeem_export">Export Excel</a>
<br><br>

<!-- Filter Kelas -->
<label for="filterKelas">Filter Kelas:</label>
<select id="filterKelas">
    <option value="">Semua</option>
    <?php
    // Ambil data
    $data = $this->model->getAllAkun();

    // Buat daftar kelas unik
    $kelasList = array_unique(array_map(fn($d) => $d['kelas'], $data));
    sort($kelasList);
    foreach ($kelasList as $kelas) {
        echo "<option value=\"" . htmlspecialchars($kelas) . "\">" . htmlspecialchars($kelas) . "</option>";
    }
    ?>
</select>

<br><br>

<table id="redeemTable" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td>
                    <a href="?page=admin_redeem_edit&id=<?= $row['id'] ?>">Edit</a> |
                    <a href="?page=admin_redeem_delete&id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
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
        const table = $('#redeemTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        // Filter kelas
        $('#filterKelas').on('change', function() {
            const val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(4).search(val ? '^' + val + '$' : '', true, false).draw(); // kolom ke-5 = index 4
        });
    });
</script>