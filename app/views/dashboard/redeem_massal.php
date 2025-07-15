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

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = $this->model->getAllAkun();
    $no = 1;
    foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['kelas'] ?></td>
            <td>
                <a href="?page=admin_redeem_edit&id=<?= $row['id'] ?>">Edit</a> |
                <a href="?page=admin_redeem_delete&id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>