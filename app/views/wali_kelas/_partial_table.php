<?php if (empty($siswaList)): ?>
    <p><em>Tidak ada data absensi untuk bulan ini.</em></p>
<?php else: ?>
    <div class="table-wrapper">
        <table class="rekap-table">
            <thead>
                <tr>
                    <th class="freeze-col col-no">NO</th>
                    <th class="freeze-col col-nis">NIS</th>
                    <th class="freeze-col col-nama">NAMA</th>
                    <?php
                    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    for ($i = 1; $i <= $jumlahHari; $i++): ?>
                        <th><?= $i ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswaList as $i => $siswa): ?>
                    <tr>
                        <td class="freeze-col col-no"><?= $i + 1 ?></td>
                        <td class="freeze-col col-nis"><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td class="freeze-col col-nama"><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <?php for ($d = 1; $d <= $jumlahHari; $d++): ?>
                            <td><?= $siswa['kehadiran'][$d] ?? '-' ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>