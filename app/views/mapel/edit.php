<h2>Edit Mapel</h2>
<form method="post">
    <label>Nama Mapel:</label><br>
    <input type="text" name="nama_mapel" value="<?= htmlspecialchars($mapel['nama_mapel']) ?>" required><br><br>

    <label>Kode Mapel:</label><br>
    <input type="text" name="kode_mapel" value="<?= htmlspecialchars($mapel['kode_mapel']) ?>" required><br><br>

    <button type="submit">Update</button>
</form>
