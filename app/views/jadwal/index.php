<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <li><a href="?page=import_jadwal">Import Jadwal</a></li>
<?php endif; ?>

<h2>Data Jadwal</h2>
<a href="?page=jadwal-create">+ Tambah Jadwal</a>
<table border="1" cellpadding="5">
    <tr>
        <th>Guru</th>
        <th>Kelas</th>
        <th>Mapel</th>
        <th>Hari</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($jadwal as $j): ?>
        <tr>
            <td><?= $j['nama_guru'] ?></td>
            <td><?= $j['nama_kelas'] ?></td>
            <td><?= $j['nama_mapel'] ?></td>
            <td><?= $j['hari'] ?></td>
            <td><?= $j['jam_mulai'] ?></td>
            <td><?= $j['jam_selesai'] ?></td>
            <td>
                <a href="?page=jadwal-edit&id=<?= $j['id_jadwal'] ?>">Edit</a> |
                <a href="?page=jadwal-delete&id=<?= $j['id_jadwal'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>