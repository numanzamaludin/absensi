<h2>Tambah Guru Mapel</h2>
<form method="post">
    <label for="id_guru">Guru:</label>
    <select name="id_guru" required>
        <option value="">-- Pilih Guru --</option>
        <?php foreach ($gurus as $guru): ?>
            <option value="<?= $guru['id_guru'] ?>"><?= $guru['nama_guru'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="id_mapel">Mata Pelajaran:</label>
    <select name="id_mapel" required>
        <option value="">-- Pilih Mapel --</option>
        <?php foreach ($mapels as $mapel): ?>
            <option value="<?= $mapel['id_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="id_kelas">Kelas:</label>
    <select name="id_kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($kelasmapels as $kelas): ?>
            <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['nama_kelas'] ?></option>
        <?php endforeach; ?>

    </select>
    <br><br>

    <button type="submit">Simpan</button>
    <a href="?page=guru_mapel_index">Batal</a>
</form>