<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <li><a href="?page=import_siswa">Import Siswa</a></li>
<?php endif; ?>



<h2>Data Siswa</h2>
<a href="?page=siswa_tambah">+ Tambah Siswa</a>
<table border="1" cellpadding="8" cellspacing="0">
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