<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

// Cegah caching agar tidak bisa kembali ke halaman setelah logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Admin</title>
</head>

<body>
    <h2>Selamat Datang, Admin!</h2>
    <p>Halo, <?= htmlspecialchars($_SESSION['user']['nama']) ?>!</p>

    <a href="?page=guru_index">Data Guru</a>
    <br>
    <a href="?page=kelas_index">Data Kelas</a>
    <br>
    <a href="?page=siswa_index">Data Siswa</a>
    <br>
    <a href="?page=mapel_index">Data Mapel</a>
    <br>
    <a href="?page=guru_mapel_index">Data Guru Mapel</a>
    <br>
    <a href="?page=wali_kelas_index">Data Wali Kelas</a>
    <br>
    <a href="?page=jadwal">Jadwal</a>
    <br>
    <a href="?page=admin_redeem"><strong>🎓 Redeem Email Massal</strong></a> <!-- ✅ Tambahan Link -->
    <br><br>
    <a href="?page=logout">Logout</a>
</body>

</html>