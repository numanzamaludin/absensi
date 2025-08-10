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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/dashboard_admin.css">
</head>

<body>
    <div class="container">
        <h2>Selamat Datang, Admin!</h2>
        <p>Halo, <?= htmlspecialchars($_SESSION['user']['nama']) ?>!</p>

        <div class="menu-grid">
            <a href="?page=guru_index">👨‍🏫 Data Guru</a>
            <a href="?page=kelas_index">🏫 Data Kelas</a>
            <a href="?page=siswa_index">👨‍🎓 Data Siswa</a>
            <a href="?page=mapel_index">📘 Data Mapel</a>
            <a href="?page=guru_mapel_index">📚 Guru Mapel</a>
            <a href="?page=wali_kelas_index">🧑‍🏫 Wali Kelas</a>
            <a href="?page=jadwal">🗓️ Jadwal</a>
            <a href="?page=admin_redeem"><strong>🎓 Redeem Email Massal</strong></a>


        </div>

        <h2>Absensi Guru</h2>
        <div class="menu-grid">
            <a href="?page=absensi_harian_guru"><strong>Live Absensi Guru</strong></a>
            <a href="?page=rekap_absensi_harian"><strong>📅 Rekap Absensi Harian</strong></a>
            <a href="?page=rekap_absensi_bulanan"><strong>📊 Rekap Absensi Bulanan</strong></a>
        </div>
        <div class="logout">
            <a href="?page=logout" class="btn-logout">🔓 Logout</a>
        </div>
    </div>

    <script src="assets/js/dashboard_admin.js"></script>
</body>

</html>