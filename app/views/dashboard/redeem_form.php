<?php
$isEdit = isset($akun);
$action = $isEdit ? 'admin_redeem_update' : 'admin_redeem_store';
?>

<h2><?= $isEdit ? 'Edit' : 'Tambah' ?> Akun</h2>

<form method="post" action="?page=<?= $action ?>">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= $akun['id'] ?>">
    <?php endif; ?>
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= $akun['nama'] ?? '' ?>" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="">--Pilih--</option>
        <option value="guru" <?= isset($akun['role']) && $akun['role'] === 'guru' ? 'selected' : '' ?>>Guru</option>
        <option value="siswa" <?= isset($akun['role']) && $akun['role'] === 'siswa' ? 'selected' : '' ?>>Siswa</option>
    </select><br><br>

    <label>Kelas:</label><br>
    <input type="text" name="kelas" value="<?= $akun['kelas'] ?? '' ?>"><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="?page=admin_redeem">← Kembali</a>