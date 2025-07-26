$(document).ready(function () {
    $('#guruTable').DataTable({
        responsive: true,
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "→",
                previous: "←"
            },
            zeroRecords: "Data tidak ditemukan",
        }
    });
});
