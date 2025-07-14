<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Guru</title>
</head>
<body>
    <h2>Form Tambah Guru</h2>

    <form method="post" action="?page=guru_tambah">
        <div>
            <label for="nama_guru">Nama Guru</label><br>
            <input type="text" name="nama_guru" id="nama_guru" required>
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="nip">NIP</label><br>
            <input type="text" name="nip" id="nip" required>
        </div>

        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required>
        </div>

        <br>
        <button type="submit">Simpan</button>
        <a href="?page=guru_index">Batal</a>
    </form>
</body>
</html>
