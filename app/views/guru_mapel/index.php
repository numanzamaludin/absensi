<h2>Daftar Guru & Mata Pelajaran</h2>
<a href="?page=guru_mapel_tambah">+ Tambah Guru Mapel</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Guru</th>
        <th>Mata Pelajaran</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1;
    foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_guru'] ?></td>
            <td><?= $row['nama_mapel'] ?></td>
            <td><?= $row['nama_kelas'] ?></td>
            <td>
                <a href="?page=guru_mapel_edit&id=<?= $row['id_guru_mapel'] ?>">Edit</a> |
                <a href="?page=guru_mapel_hapus&id=<?= $row['id_guru_mapel'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>