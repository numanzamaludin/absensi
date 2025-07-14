<h2>Tambah Siswa</h2>
<form method="post">
    <label>Nama:</label><br>
    <input type="text" name="nama_siswa" required><br><br>

    <label>NIS:</label><br>
    <input type="text" name="nis" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Kelas:</label><br>
    <select name="id_kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($kelasList as $kelas): ?>
            <option value="<?= $kelas['id_kelas'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
        <?php endforeach ?>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>
