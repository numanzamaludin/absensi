<h2>Import Jadwal</h2>

<form action="index.php?page=proses_import_jadwal" method="post" enctype="multipart/form-data">
    <label for="file">Pilih file Excel:</label>
    <input type="file" name="file" id="file" accept=".xlsx" required>
    <button type="submit">Upload</button>
</form>

<p><a href="index.php?page=download_template_jadwal">Download Template Excel</a></p>