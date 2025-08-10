$(document).ready(function() {
    $('#rekapBulanan').DataTable({
        pageLength: 100
    });

    $('.btn-detail').on('click', function(e) {
        e.preventDefault();
        let detailData = $(this).data('detail');
        let pesan = '';
        detailData.forEach(function(d) {
            pesan += `${d.tanggal} - ${d.mapel} (${d.kelas})\n`;
        });
        alert(pesan);
    });
});
