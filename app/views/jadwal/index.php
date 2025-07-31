<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

require_once __DIR__ . '/../../models/JadwalModel.php';
$jadwalModel = new JadwalModel();
$jadwal = $jadwalModel->getAll();

// Ambil daftar guru, kelas, mapel, hari unik
$guruList = array_unique(array_column($jadwal, 'nama_guru'));
$kelasList = array_unique(array_column($jadwal, 'nama_kelas'));
$mapelList = array_unique(array_column($jadwal, 'nama_mapel'));
$hariList = array_unique(array_column($jadwal, 'hari'));

sort($guruList);
sort($kelasList);
sort($mapelList);
sort($hariList);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h3 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Data Jadwal</h3>
                <div class="d-flex flex-wrap gap-2">
                    <a href="?page=dashboard" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Dashboard</a>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="?page=import_jadwal" class="btn btn-info text-white"><i class="bi bi-upload"></i> Import</a>
                    <?php endif; ?>
                    <a href="?page=jadwal-create" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Jadwal</a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label for="filterGuru" class="form-label fw-semibold">Guru</label>
                    <select id="filterGuru" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($guruList as $g): ?>
                            <option><?= htmlspecialchars($g) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterKelas" class="form-label fw-semibold">Kelas</label>
                    <select id="filterKelas" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($kelasList as $k): ?>
                            <option><?= htmlspecialchars($k) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterMapel" class="form-label fw-semibold">Mapel</label>
                    <select id="filterMapel" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($mapelList as $m): ?>
                            <option><?= htmlspecialchars($m) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterHari" class="form-label fw-semibold">Hari</label>
                    <select id="filterHari" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($hariList as $h): ?>
                            <option><?= htmlspecialchars($h) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <button id="resetFilter" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Reset Filter</button>
            </div>

            <!-- Jadwal Table -->
            <table id="jadwalTable" class="table table-bordered table-hover">
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

    <!-- JS: jQuery + Bootstrap + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Filtering Script -->
    <script>
        $(document).ready(function() {
            const table = $('#jadwalTable').DataTable({
                dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-end"Bf>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
                buttons: ['excel'],
                responsive: true,
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    zeroRecords: "Tidak ada data ditemukan.",
                    paginate: {
                        next: "→",
                        previous: "←"
                    }
                }
            });

            function filterColumn(selectId, columnIndex) {
                $(selectId).on('change', function() {
                    const val = $.fn.dataTable.util.escapeRegex($(this).val());
                    table.column(columnIndex).search(val ? '^' + val + '$' : '', true, false).draw();
                });
            }

            filterColumn('#filterGuru', 0);
            filterColumn('#filterKelas', 1);
            filterColumn('#filterMapel', 2);
            filterColumn('#filterHari', 3);

            $('#resetFilter').on('click', function() {
                $('#filterGuru, #filterKelas, #filterMapel, #filterHari').val('');
                table.columns().search('').draw();
            });
        });
    </script>
</body>

</html>