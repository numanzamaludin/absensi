<h2>Daftar Guru</h2>
<a href="?page=dashboard">⬅ Kembali ke Dashboard</a>
<br><br>

<a href="?page=guru_tambah">+ Tambah Guru</a>
<br><br>
<a href="?page=guru_import">📥 Import Guru</a>
<br><br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php $no = 1;
            foreach ($data as $guru): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($guru['nama_guru']) ?></td>
                    <td><?= htmlspecialchars($guru['email']) ?></td>
                    <td>
                        <a href="?page=guru_edit&id=<?= $guru['id_guru'] ?>">Edit</a> |
                        <a href="?page=guru_hapus&id=<?= $guru['id_guru'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada data guru.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>