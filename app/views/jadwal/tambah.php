<h2>Tambah Jadwal</h2>

<?php
// Urutkan $guruMapel berdasarkan nama_guru, nama_mapel, nama_kelas
usort($guruMapel, function ($a, $b) {
    return strcmp(
        $a['nama_guru'] . $a['nama_mapel'] . $a['nama_kelas'],
        $b['nama_guru'] . $b['nama_mapel'] . $b['nama_kelas']
    );
});
?>

<form method="POST" action="index.php?page=jadwal-store">
    <label for="id_guru_mapel">Guru - Mapel - Kelas</label>
    <select name="id_guru_mapel" required>
        <option value="">-- Pilih --</option>
        <?php foreach ($guruMapel as $gm): ?>
            <option value="<?= $gm['id_guru_mapel'] ?>">
                <?= $gm['nama_guru'] ?> - <?= $gm['nama_mapel'] ?> - <?= $gm['nama_kelas'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="hari">Hari</label>
    <select name="hari" required>
        <option value="">-- Pilih Hari --</option>
        <?php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        foreach ($hariList as $hari): ?>
            <option value="<?= $hari ?>"><?= $hari ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="jam_mulai">Jam Mulai</label>
    <input type="time" name="jam_mulai" value="00:00:00" required>
    <br>

    <label for="jam_selesai">Jam Selesai</label>
    <input type="time" name="jam_selesai" value="23:59:00" required>
    <br>

    <button type="submit">Simpan</button>
</form>