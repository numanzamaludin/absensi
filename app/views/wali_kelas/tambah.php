<h2>Tambah Wali Kelas</h2>
<form method="post">
    <label>Guru</label><br>
    <select name="id_guru" required>
        <option value="">-- Pilih Guru --</option>
        <?php foreach ($gurus as $g): ?>
        <option value="<?= $g['id_guru'] ?>"><?= $g['nama_guru'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Kelas</label><br>
    <select name="id_kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($kelas as $k): ?>
        <option value="<?= $k['id_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>
