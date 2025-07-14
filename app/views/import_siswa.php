<h2>Import Data Siswa</h2>

<a href="?page=download_template_siswa">
    <button type="button">Download Template Excel</button>
</a>

<br><br>

<form action="?page=proses_import_siswa" method="post" enctype="multipart/form-data">
    <label for="file">Pilih File Excel (.xlsx):</label>
    <input type="file" name="file" accept=".xlsx,.xls" required>
    <button type="submit">Import</button>
</form>
