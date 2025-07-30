<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <li><a href="?page=import_siswa">Import Siswa</a></li>
<?php endif; ?>

<h2>Data Siswa</h2>


<form method="get" style="margin: 15px 0;">
    <input type="hidden" name="page" value="siswa_index">
    <label for="filter_kelas">Filter Kelas:</label>
    <select name="filter_kelas" id="filter_kelas" onchange="this.form.submit()">
        <option value="">-- Semua Kelas --</option>
        <?php foreach ($kelasList as $kelas): ?>
            <option value="<?= $kelas['id_kelas'] ?>" <?= (isset($_GET['filter_kelas']) && $_GET['filter_kelas'] == $kelas['id_kelas']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kelas['nama_kelas']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>




<a href="?page=siswa_tambah">+ Tambah Siswa</a>

<!-- Form bulk update -->
<form method="post" action="?page=siswa_bulk_update">
    <div style="margin: 10px 0;">
        <select name="kelas_baru" required>
            <option value="">-- Pilih Kelas Baru --</option>
            <?php foreach ($kelasList as $kelas): ?>
                <option value="<?= $kelas['id_kelas'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" onclick="return confirm('Yakin update kelas siswa yang dipilih?')">Update Semua</button>
    </div>

    <!-- Tabel siswa -->
    <table id="siswaTable" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th><input type="checkbox" onclick="toggleAll(this)"></th>
                <th>No</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php $no = 1;
                foreach ($data as $siswa): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_ids[]" value="<?= $siswa['id_siswa'] ?>"></td>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td><?= htmlspecialchars($siswa['email']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_kelas'] ?? '-') ?></td>
                        <td>
                            <a href="?page=siswa_edit&id=<?= $siswa['id_siswa'] ?>">Edit</a> |
                            <a href="?page=siswa_hapus&id=<?= $siswa['id_siswa'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada data.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</form>

<!-- DataTables & Custom JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Load JS kustom -->
<script src="assets/js/siswa_index.js"></script>