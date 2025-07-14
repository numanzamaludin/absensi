<h2>Data Kelas</h2>
<a href="?page=kelas_tambah">+ Tambah Kelas</a>
<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($data as $i => $k): ?>
    <tr>
        <td><?= $i+1 ?></td>
        <td><?= htmlspecialchars($k['nama_kelas']) ?></td>
        <td>
            <a href="?page=kelas_edit&id=<?= $k['id_kelas'] ?>">Edit</a> |
            <a href="?page=kelas_hapus&id=<?= $k['id_kelas'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
