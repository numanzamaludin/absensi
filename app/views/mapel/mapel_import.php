<h2>Import Data Mata Pelajaran</h2>

<a href="?page=mapel_index">⬅ Kembali ke Daftar Mapel</a><br><br>

<form action="?page=mapel_import_proses" method="POST" enctype="multipart/form-data">
    <label>Pilih file Excel (.xlsx):</label><br>
    <input type="file" name="file_excel" accept=".xlsx" required><br><br>
    <button type="submit">📥 Import</button>
</form>

<br>
<p><a href="public/assets/template_mapel.xlsx" download>📄 Unduh Template Excel Mapel</a></p>