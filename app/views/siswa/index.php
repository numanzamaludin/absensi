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
    <title>Data Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/siswa_index.css">
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-people-fill me-2"></i>Data Siswa</h3>
            <a href="?page=dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="card shadow-sm p-4">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <a href="?page=siswa_tambah" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Siswa
                    </a>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="?page=import_siswa" class="btn btn-info text-white">
                            <i class="bi bi-upload"></i> Import Siswa
                        </a>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="filterKelas" class="form-label mb-0">Filter Kelas:</label>
                    <select id="filterKelas" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <?php
                        $kelasList = array_unique(array_map(fn($s) => $s['nama_kelas'], $data));
                        sort($kelasList);
                        foreach ($kelasList as $kelas) {
                            echo '<option value="' . htmlspecialchars($kelas) . '">' . htmlspecialchars($kelas) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table id="siswaTable" class="table table-striped table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php $no = 1;
                            foreach ($data as $siswa): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                    <td><?= htmlspecialchars($siswa['nis']) ?></td>
                                    <td><?= htmlspecialchars($siswa['email']) ?></td>
                                    <td><?= htmlspecialchars($siswa['nama_kelas']) ?></td>
                                    <td>
                                        <a href="?page=siswa_edit&id=<?= $siswa['id_siswa'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="?page=siswa_hapus&id=<?= $siswa['id_siswa'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/siswa_index.js"></script>
</body>

</html>