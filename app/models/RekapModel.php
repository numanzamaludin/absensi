<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/core/Database.php';

class RekapModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Rekap absensi bulanan per siswa per mata pelajaran dalam satu kelas.
     */
    public function getRekapBulananPerMapel($id_kelas, $bulan, $tahun)
    {
        $stmt = $this->db->prepare("
            SELECT 
                s.nama_siswa,
                m.nama_mapel,
                COUNT(CASE WHEN d.status_kehadiran = 'hadir' THEN 1 END) AS hadir,
                COUNT(CASE WHEN d.status_kehadiran = 'izin' THEN 1 END) AS izin,
                COUNT(CASE WHEN d.status_kehadiran = 'sakit' THEN 1 END) AS sakit,
                COUNT(CASE WHEN d.status_kehadiran = 'alpa' THEN 1 END) AS alpa
            FROM absensi_detail d
            JOIN absensi a ON d.id_absensi = a.id_absensi
            JOIN siswa s ON d.id_siswa = s.id_siswa
            JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
            JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
            WHERE s.id_kelas = :id_kelas
              AND MONTH(a.tanggal) = :bulan
              AND YEAR(a.tanggal) = :tahun
            GROUP BY s.id_siswa, m.nama_mapel
            ORDER BY m.nama_mapel, s.nama_siswa
        ");
        $stmt->execute([
            'id_kelas' => $id_kelas,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getRekapHarianPerSiswa($id_kelas, $bulan, $tahun)
    {
        $stmt = $this->db->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.nis
        FROM siswa s
        WHERE s.id_kelas = :id_kelas
        ORDER BY s.nama_siswa
    ");
        $stmt->execute(['id_kelas' => $id_kelas]);
        $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        foreach ($siswaList as &$siswa) {
            $siswa['kehadiran'] = array_fill(1, $jumlahHari, '-'); // default: '-'

            $stmt = $this->db->prepare("
            SELECT DAY(a.tanggal) AS tgl, ad.status_kehadiran
            FROM absensi_detail ad
            JOIN absensi a ON ad.id_absensi = a.id_absensi
            WHERE ad.id_siswa = :id_siswa
              AND MONTH(a.tanggal) = :bulan
              AND YEAR(a.tanggal) = :tahun
              AND a.status_wali_kelas = 'disetujui'
        ");
            $stmt->execute([
                'id_siswa' => $siswa['id_siswa'],
                'bulan' => $bulan,
                'tahun' => $tahun
            ]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $hari = (int)$row['tgl'];
                $kode = strtoupper(substr($row['status_kehadiran'], 0, 1)); // H/I/S/A
                $siswa['kehadiran'][$hari] = $kode;
            }
        }

        return $siswaList;
    }






    public function getKehadiranFinalHarian($id_kelas, $tanggal)
    {
        $stmt = $this->db->prepare("
        SELECT s.id_siswa, s.nama_siswa, k.nama_kelas, a.tanggal, mp.nama_mapel, ad.status_kehadiran
        FROM absensi a
        JOIN absensi_detail ad ON ad.id_absensi = a.id_absensi
        JOIN siswa s ON s.id_siswa = ad.id_siswa
        JOIN kelas k ON s.id_kelas = k.id_kelas
        JOIN guru_mapel gm ON gm.id_guru_mapel = a.id_guru_mapel
        JOIN mata_pelajaran mp ON mp.id_mapel = gm.id_mapel
        WHERE a.id_kelas = :id_kelas
          AND a.tanggal = :tanggal
          AND a.status_wali_kelas = 'disetujui'
        ORDER BY s.nama_siswa, mp.nama_mapel
    ");
        $stmt->execute([
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kelompokkan berdasarkan siswa
        $grouped = [];
        foreach ($rows as $row) {
            $id = $row['id_siswa'];
            $grouped[$id]['nama_siswa'] = $row['nama_siswa'];
            $grouped[$id]['nama_kelas'] = $row['nama_kelas'];
            $grouped[$id]['tanggal'] = $row['tanggal'];
            $grouped[$id]['mapel'][$row['nama_mapel']] = $row['status_kehadiran'];
        }

        // Hitung status final
        foreach ($grouped as &$g) {
            $final = 'hadir'; // default
            foreach ($g['mapel'] as $status) {
                if ($status === 'alpa') {
                    $final = 'alpa';
                    break;
                } elseif ($status === 'sakit' && $final !== 'alpa') {
                    $final = 'sakit';
                } elseif ($status === 'izin' && !in_array($final, ['alpa', 'sakit'])) {
                    $final = 'izin';
                }
            }
            $g['final'] = $final;
        }

        return $grouped;
    }





    public function getKehadiranHarianByWali($id_guru, $tanggal)
    {
        $stmt = $this->db->prepare("
        SELECT 
            s.id_siswa,
            s.nama_siswa,
            k.id_kelas,
            k.nama_kelas,
            mp.nama_mapel,
            ad.status_kehadiran
        FROM absensi_detail ad
        JOIN absensi a ON a.id_absensi = ad.id_absensi
        JOIN siswa s ON s.id_siswa = ad.id_siswa
        JOIN kelas k ON s.id_kelas = k.id_kelas
        JOIN guru_mapel gm ON gm.id_guru_mapel = a.id_guru_mapel
        JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
        JOIN wali_kelas wk ON wk.id_kelas = s.id_kelas
        WHERE a.tanggal = :tanggal
          AND wk.id_guru = :id_guru
          AND a.status_wali_kelas = 'disetujui'
        ORDER BY s.nama_siswa
    ");
        $stmt->execute([
            'tanggal' => $tanggal,
            'id_guru' => $id_guru
        ]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format ulang agar sesuai tampilan tabel
        $output = [];
        foreach ($result as $row) {
            $id = $row['id_siswa'];
            $mapel = $row['nama_mapel'];
            $status = $row['status_kehadiran'];

            if (!isset($output[$id])) {
                $output[$id] = [
                    'nama_siswa' => $row['nama_siswa'],
                    'nama_kelas' => $row['nama_kelas'],
                    'id_kelas' => $row['id_kelas'],
                    'mapel' => [],
                ];
            }

            $output[$id]['mapel'][$mapel] = $status;
        }

        // Hitung absen final
        foreach ($output as &$s) {
            $statusList = array_values($s['mapel']);

            if (in_array('alpa', $statusList)) {
                $s['final'] = 'alpa';
            } elseif (in_array('sakit', $statusList)) {
                $s['final'] = 'sakit';
            } elseif (in_array('izin', $statusList)) {
                $s['final'] = 'izin';
            } elseif (in_array('hadir', $statusList)) {
                $s['final'] = 'hadir';
            } else {
                $s['final'] = '-';
            }
        }

        return array_values($output);
    }


    public function getDetailAbsensiPerSiswa($id_kelas, $id_mapel, $bulan, $tahun)
    {
        $stmt = $this->db->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.nis
        FROM siswa s
        WHERE s.id_kelas = :id_kelas
        ORDER BY s.nama_siswa
    ");
        $stmt->execute(['id_kelas' => $id_kelas]);
        $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($siswaList as &$siswa) {
            $siswa['kehadiran'] = [];

            $stmt = $this->db->prepare("
            SELECT DAY(a.tanggal) as hari, ad.status_kehadiran
            FROM absensi_detail ad
            JOIN absensi a ON a.id_absensi = ad.id_absensi
            JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
            WHERE ad.id_siswa = :id_siswa
              AND a.id_kelas = :id_kelas
              AND gm.id_mapel = :id_mapel
              AND MONTH(a.tanggal) = :bulan
              AND YEAR(a.tanggal) = :tahun
              AND a.status_wali_kelas = 'disetujui'
        ");
            $stmt->execute([
                'id_siswa' => $siswa['id_siswa'],
                'id_kelas' => $id_kelas,
                'id_mapel' => $id_mapel,
                'bulan' => $bulan,
                'tahun' => $tahun
            ]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $siswa['kehadiran'][(int)$row['hari']] = strtoupper(substr($row['status_kehadiran'], 0, 1)); // H/I/S/A
            }
        }

        return $siswaList;
    }


    public function getDetailAbsensiBulananPerMapel($id_kelas, $id_mapel, $bulan, $tahun)
    {
        $stmt = $this->db->prepare("
        SELECT s.id_siswa, s.nama_siswa, s.nis
        FROM siswa s
        WHERE s.id_kelas = :id_kelas
        ORDER BY s.nama_siswa
    ");
        $stmt->execute(['id_kelas' => $id_kelas]);
        $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($siswaList as &$siswa) {
            $siswa['kehadiran'] = array_fill(1, 31, '');
            $stmt2 = $this->db->prepare("
            SELECT DAY(a.tanggal) AS tgl, ad.status_kehadiran
            FROM absensi_detail ad
            JOIN absensi a ON ad.id_absensi = a.id_absensi
            JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
            WHERE ad.id_siswa = :id_siswa
              AND gm.id_mapel = :id_mapel
              AND a.id_kelas = :id_kelas
              AND MONTH(a.tanggal) = :bulan
              AND YEAR(a.tanggal) = :tahun
              AND a.status_wali_kelas = 'disetujui'
        ");
            $stmt2->execute([
                'id_siswa' => $siswa['id_siswa'],
                'id_mapel' => $id_mapel,
                'id_kelas' => $id_kelas,
                'bulan'    => $bulan,
                'tahun'    => $tahun
            ]);

            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $siswa['kehadiran'][(int)$row['tgl']] = strtoupper(substr($row['status_kehadiran'], 0, 1));
            }
        }

        return $siswaList;
    }

    public function getInfoMapelKelas($id_kelas, $id_mapel)
    {
        $stmt = $this->db->prepare("
        SELECT k.nama_kelas, m.nama_mapel, g.nama_guru as wali_kelas
        FROM kelas k
        JOIN mata_pelajaran m
        LEFT JOIN wali_kelas wk ON wk.id_kelas = k.id_kelas
        LEFT JOIN guru g ON g.id_guru = wk.id_guru
        WHERE k.id_kelas = ? AND m.id_mapel = ?
        LIMIT 1
    ");
        $stmt->execute([$id_kelas, $id_mapel]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
