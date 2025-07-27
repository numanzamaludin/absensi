<?php if (empty($jadwalGabung)): ?>
    <div class="alert alert-warning text-center">
        Tidak ada jadwal aktif saat ini.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table id="absensiTable" class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Guru</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Waktu Absensi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwalGabung as $row): ?>
                    <tr class="<?= $row['sudah_absen'] ? 'table-success' : 'table-danger'; ?>">
                        <td><?= htmlspecialchars($row['nama_guru']); ?></td>
                        <td><?= htmlspecialchars($row['nama_kelas']); ?></td>
                        <td><?= htmlspecialchars($row['nama_mapel']); ?></td>
                        <td><?= $row['jam_mulai']; ?></td>
                        <td><?= $row['jam_selesai']; ?></td>
                        <td><?= $row['sudah_absen'] ? $row['waktu_absen'] : '<span class="text-danger">Belum Absen</span>'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>