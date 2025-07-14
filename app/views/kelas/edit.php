<h2>Edit Kelas</h2>
<form method="post">
    <label>Nama Kelas:</label>
    <input type="text" name="nama_kelas" value="<?= htmlspecialchars($kelas['nama_kelas']) ?>" required>
    <br><br>
    <button type="submit">Update</button>
    <a href="?page=kelas_index">Batal</a>
</form>
