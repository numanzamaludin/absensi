<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

// Ambil data akun
$data = $this->model->getAllAkun();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Redeem Email Massal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/redeem.css">
</head>

<body>
    <div class="container my-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-2">
                <h3 class="mb-0"><i class="bi bi-people-fill me-2"></i>Redeem Email Massal</h3>
                <div class="d-flex flex-wrap gap-2">
                    <a href="?page=dashboard" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Dashboard</a>
                    <a href="?page=admin_redeem_create" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Akun</a>
                    <a href="?page=admin_redeem_export" class="btn btn-outline-primary"><i class="bi bi-file-earmark-arrow-down"></i> Export Excel</a>
                </div>
            </div>

            <!-- Form Import -->
            <form method="post" enctype="multipart/form-data" action="?page=admin_redeem_import" class="mb-4 d-flex gap-3 flex-wrap">
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Import Excel</button>
            </form>

            <!-- Filter Kelas -->
            <div class="mb-3 row">
                <label for="filterKelas" class="col-sm-2 col-form-label fw-semibold">Filter Kelas:</label>
                <div class="col-sm-6">
                    <select id="filterKelas" class="form-select">
                        <option value="">Semua</option>
                        <?php
                        $kelasList = array_unique(array_map(fn($d) => $d['kelas'], $data));
                        sort($kelasList);
                        foreach ($kelasList as $kelas) {
                            echo "<option value=\"" . htmlspecialchars($kelas) . "\">" . htmlspecialchars($kelas) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <table id="redeemTable" class="table table-bordered table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td>
                                <a href="?page=admin_redeem_edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=admin_redeem_delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Custom Script -->
    <script src="assets/js/redeem.js"></script>
</body>

</html>