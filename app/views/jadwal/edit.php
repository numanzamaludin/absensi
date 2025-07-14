<h2>Edit Jadwal</h2>

<form method="POST" action="index.php?page=jadwal-update">
    <input type="hidden" name="id" value="<?= $jadwal['id_jadwal'] ?>">

    <label for="id_guru_mapel">Guru - Mapel - Kelas</label>
    <select name="id_guru_mapel" required>
        <?php foreach ($guruMapel as $gm): ?>
            <option value="<?= $gm['id_guru_mapel'] ?>" <?= $jadwal['id_guru_mapel'] == $gm['id_guru_mapel'] ? 'selected' : '' ?>>
                <?= $gm['nama_guru'] ?> - <?= $gm['nama_mapel'] ?> - <?= $gm['nama_kelas'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="hari">Hari</label>
    <select name="hari" required>
        <?php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        foreach ($hariList as $hari): ?>
            <option value="<?= $hari ?>" <?= $jadwal['hari'] == $hari ? 'selected' : '' ?>><?= $hari ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="jam_mulai">Jam Mulai</label>
    <input type="time" name="jam_mulai" value="<?= $jadwal['jam_mulai'] ?>" required>
    <br>

    <label for="jam_selesai">Jam Selesai</label>
    <input type="time" name="jam_selesai" value="<?= $jadwal['jam_selesai'] ?>" required>
    <br>

    <button type="submit">Update</button>
</form>