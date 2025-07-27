<h2>Edit Guru</h2>

<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama_guru" value="<?= htmlspecialchars($guru['nama_guru']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($guru['email']) ?>" required><br><br>

    <label>Password (biarkan kosong jika tidak diubah):</label><br>
    <input type="password" name="password"><br><br>

    
<!-- <select name="role" required>
        <option value="guru">Guru</option>
        <option value="admin">Admin</option>
    </select><br><br> -->


    <button type="submit">Update</button>
</form>

<p><a href="?page=guru_index">Kembali</a></p>
