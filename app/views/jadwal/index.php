<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Jadwal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/jadwal.css">
</head>

<body>
    <div class="container my-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h3 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Data Jadwal</h3>
                <div class="d-flex flex-wrap gap-2">
                    <a href="?page=dashboard" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="?page=import_jadwal" class="btn btn-info text-white"><i class="bi bi-upload"></i> Import Jadwal</a>
                    <?php endif; ?>
                    <a href="?page=jadwal-create" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Jadwal</a>
                </div>
            </div>

            <!-- Filter Guru -->
            <div class="mb-3 row">
                <label for="filterGuru" class="col-sm-2 col-form-label fw-semibold">Filter Nama Guru:</label>
                <div class="col-sm-6">
                    <select id="filterGuru" class="form-select">
                        <option value="">Semua Guru</option>
                        <?php
                        $guruList = array_unique(array_map(fn($j) => $j['nama_guru'], $jadwal));
                        sort($guruList);
                        foreach ($guruList as $guru) {
                            echo '<option value="' . htmlspecialchars($guru) . '">' . htmlspecialchars($guru) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Tabel Jadwal -->
            <table id="jadwalTable" class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j): ?>
                        <tr>
                            <td><?= htmlspecialchars($j['nama_guru']) ?></td>
                            <td><?= htmlspecialchars($j['nama_kelas']) ?></td>
                            <td><?= htmlspecialchars($j['nama_mapel']) ?></td>
                            <td><?= htmlspecialchars($j['hari']) ?></td>
                            <td><?= htmlspecialchars($j['jam_mulai']) ?></td>
                            <td><?= htmlspecialchars($j['jam_selesai']) ?></td>
                            <td>
                                <a href="?page=jadwal-edit&id=<?= $j['id_jadwal'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=jadwal-delete&id=<?= $j['id_jadwal'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/jadwal.js"></script>
</body>

</html>