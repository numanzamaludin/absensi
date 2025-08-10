$(document).ready(function() {
    $('#rekapBulanan').DataTable({
        pageLength: 100,
        lengthChange: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        },
        responsive: true,
        columnDefs: [
            { orderable: false, targets: 5 } // Disable sorting on 'Detail' column
        ]
    });
});
