<h2>Data Mata Pelajaran</h2>
<a href="?page=mapel_tambah">+ Tambah Mapel</a>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Mapel</th>
        <th>Kode Mapel</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1;
    foreach ($data as $mapel): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($mapel['nama_mapel']) ?></td>
            <td><?= htmlspecialchars($mapel['kode_mapel']) ?></td>
            <td>
                <a href="?page=mapel_edit&id=<?= $mapel['id_mapel'] ?>">Edit</a> |
                <a href="?page=mapel_hapus&id=<?= $mapel['id_mapel'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>