$(document).ready(function () {
    const table = $('#redeemTable').DataTable({
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-end"Bf>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        buttons: ['excel'],
        responsive: true,
        lengthMenu: [10, 20, 50, 100],
        pageLength: 10,
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

    // Filter berdasarkan kelas (kolom ke-5 = index 4)
    $('#filterKelas').on('change', function () {
        const val = $.fn.dataTable.util.escapeRegex($(this).val());
        table.column(4).search(val ? '^' + val + '$' : '', true, false).draw();
    });
});
