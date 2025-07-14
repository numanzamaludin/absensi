<h2>Data Wali Kelas</h2>
<a href="?page=wali_kelas_tambah">+ Tambah Wali Kelas</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Guru</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; foreach ($data as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_guru']) ?></td>
        <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
        <td>
            <a href="?page=wali_kelas_edit&id=<?= $row['id_wali_kelas'] ?>">Edit</a> |
            <a href="?page=wali_kelas_hapus&id=<?= $row['id_wali_kelas'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
