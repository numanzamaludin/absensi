<?php
// Jaga-jaga jika variabel tidak tersedia
$tanggalDipilih = $tanggalDipilih ?? date('j');
$bulanDipilih   = $bulanDipilih ?? date('n');
$tahunDipilih   = $tahunDipilih ?? date('Y');

$tanggal = sprintf('%04d-%02d-%02d', $tahunDipilih, $bulanDipilih, $tanggalDipilih);

// Mapping hari
$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];
$hariEng = date('l', strtotime($tanggal));
$hariIndo = $hariMap[$hariEng] ?? $hariEng;

// Default kelas dan wali
$kelas = $kelas ?? '-';
$wali = $wali ?? '-';
?>

<!-- 📋 INFO KELAS -->
<div class="card info-card">
    <p><strong>Kelas:</strong> <?= htmlspecialchars(is_array($kelas) ? $kelas['nama_kelas'] ?? '-' : $kelas) ?></p>
    <p><strong>Wali Kelas:</strong> <?= htmlspecialchars(is_array($wali) ? $wali['nama_guru'] ?? '-' : $wali) ?></p>
    <p><strong>Tanggal:</strong> <?= "$tanggalDipilih " . date('F', mktime(0, 0, 0, $bulanDipilih, 1)) . " $tahunDipilih ($hariIndo)" ?></p>
</div>

<!-- 📊 TABEL ABSENSI -->
<?php if (empty($data)): ?>
    <p><em>Tidak ada data kehadiran pada tanggal ini.</em></p>
<?php else: ?>
    <div class="table-scroll">
        <table class="absensi-table" border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <?php
                    $mapelList = array_keys(reset($data)['mapel']);
                    foreach ($mapelList as $m): ?>
                        <th><?= htmlspecialchars($m) ?></th>
                    <?php endforeach; ?>
                    <th><strong>Absen Final</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $siswa): ?>
                    <tr>
                        <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_kelas']) ?></td>
                        <?php foreach ($mapelList as $m): ?>
                            <td><?= htmlspecialchars($siswa['mapel'][$m] ?? '-') ?></td>
                        <?php endforeach; ?>
                        <td><strong><?= strtoupper($siswa['final']) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>