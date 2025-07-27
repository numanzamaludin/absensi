<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Live Rekap Absensi Guru Hari Ini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <!-- Tombol Kembali -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">📋 Live Rekap Absensi Guru Hari Ini</h2>
            <a href="index.php?page=dashboard" class="btn btn-outline-primary">
                🔙 Kembali ke Dashboard
            </a>
        </div>

        <!-- Konten Live Absensi -->
        <div id="live-absensi-content">
            <?php include __DIR__ . '/table_absensi_live.php'; ?>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function loadAbsensiLive() {
            $.get('index.php?page=loadAbsensiLive', function(data) {
                $('#live-absensi-content').html(data);
                $('#absensiTable').DataTable({
                    destroy: true,
                    pageLength: 100,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    },
                    order: [
                        [3, 'asc']
                    ],
                    responsive: true
                });
            });
        }

        $(document).ready(function() {
            loadAbsensiLive(); // initial load
            setInterval(loadAbsensiLive, 60000); // refresh setiap 60 detik
        });
    </script>

</body>

</html>