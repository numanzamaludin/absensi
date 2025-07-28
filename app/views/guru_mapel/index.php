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
    <title>Daftar Guru & Mapel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/guru_mapel.css">
</head>

<body>
    <div class="container my-5">


        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash'];
                unset($_SESSION['flash']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>



        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-journal-text me-2"></i>Daftar Guru & Mata Pelajaran</h3>
            <a href="?page=dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="card shadow-sm p-4">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <a href="?page=guru_mapel_tambah" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Guru Mapel
                </a>


                <!-- Tombol Import -->
                <form action="?page=guru_mapel_import" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    <input type="file" name="import_file" accept=".xlsx,.xls" required class="form-control form-control-sm" style="max-width: 250px;">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-upload"></i> Import Excel
                    </button>
                </form>

                <a href="?page=unduh_template_guru_mapel" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-download"></i> Unduh Template Excel
                </a>





                <div class="d-flex align-items-center gap-2">
                    <label for="filterGuru" class="form-label mb-0">Filter Nama Guru:</label>
                    <select id="filterGuru" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <?php
                        $guruList = array_unique(array_map(fn($d) => $d['nama_guru'], $data));
                        sort($guruList);
                        foreach ($guruList as $guru) {
                            echo '<option value="' . htmlspecialchars($guru) . '">' . htmlspecialchars($guru) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>






            <div class="table-responsive">
                <table id="guruMapelTable" class="table table-striped table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                                <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td>
                                    <a href="?page=guru_mapel_edit&id=<?= $row['id_guru_mapel'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="?page=guru_mapel_hapus&id=<?= $row['id_guru_mapel'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JS -->
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
    <script src="assets/js/guru_mapel.js"></script>
</body>

</html>