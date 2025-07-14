<h2>Edit Siswa</h2>
<form method="post">
    <label>Nama:</label><br>
    <input type="text" name="nama_siswa" value="<?= htmlspecialchars($siswa['nama_siswa']) ?>" required><br><br>

    <label>NIS:</label><br>
    <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($siswa['email']) ?>" required><br><br>

    <label>Password (kosongkan jika tidak diubah):</label><br>
    <input type="password" name="password"><br><br>

    <label>Kelas:</label><br>
    <select name="id_kelas" required>
        <?php foreach ($kelasList as $kelas): ?>
            <option value="<?= $kelas['id_kelas'] ?>" <?= $kelas['id_kelas'] == $siswa['id_kelas'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($kelas['nama_kelas']) ?>
            </option>
        <?php endforeach ?>
    </select><br><br>

    <button type="submit">Update</button>
</form>
