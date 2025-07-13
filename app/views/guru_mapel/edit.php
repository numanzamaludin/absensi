<h2>Edit Guru Mapel</h2>
<form method="post">
    <label for="id_guru">Guru:</label>
    <select name="id_guru" required>
        <option value="">-- Pilih Guru --</option>
        <?php foreach ($gurus as $guru): ?>
            <option value="<?= $guru['id_guru'] ?>" <?= $guru['id_guru'] == $data['id_guru'] ? 'selected' : '' ?>>
                <?= $guru['nama_guru'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="id_mapel">Mata Pelajaran:</label>
    <select name="id_mapel" required>
        <option value="">-- Pilih Mapel --</option>
        <?php foreach ($mapels as $mapel): ?>
            <option value="<?= $mapel['id_mapel'] ?>" <?= $mapel['id_mapel'] == $data['id_mapel'] ? 'selected' : '' ?>>
                <?= $mapel['nama_mapel'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Update</button>
    <a href="?page=guru_mapel_index">Batal</a>
</form>
