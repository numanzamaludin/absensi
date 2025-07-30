function toggleAll(source) {
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
    checkboxes.forEach(cb => cb.checked = source.checked);
}

$(document).ready(function () {
    $('#siswaTable').DataTable({
        dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"Bf>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>',
        buttons: ['excel'],
        responsive: true,
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            zeroRecords: "Tidak ada data ditemukan.",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "→",
                previous: "←"
            },
        }
    });
});
