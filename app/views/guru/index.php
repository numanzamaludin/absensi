<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

// Data guru seharusnya berasal dari controller / model
// Misal: $data = GuruModel::getAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/guru_index.css">
</head>

<body>
    <div class="container my-4">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4"><i class="bi bi-journal-text me-2"></i>Daftar Guru</h3>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="?page=dashboard" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
                </a>
                <a href="?page=guru_tambah" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Guru
                </a>
                <a href="?page=guru_import" class="btn btn-info text-white">
                    <i class="bi bi-upload"></i> Import Guru
                </a>
            </div>

            <table id="guruTable" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php $no = 1;
                        foreach ($data as $guru): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($guru['nama_guru']) ?></td>
                                <td><?= htmlspecialchars($guru['email']) ?></td>
                                <td>
                                    <a href="?page=guru_edit&id=<?= $guru['id_guru'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="?page=guru_hapus&id=<?= $guru['id_guru'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data guru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/guru_index.js"></script>
</body>

</html>