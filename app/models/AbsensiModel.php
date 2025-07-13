<?php
require_once __DIR__ . '/../../core/Database.php';


class AbsensiModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getSiswaByKelas($id_kelas)
    {
        $stmt = $this->db->prepare("SELECT * FROM siswa WHERE id_kelas = :id_kelas");
        $stmt->execute(['id_kelas' => $id_kelas]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertAbsensi($id_guru_mapel, $id_kelas, $tanggal, $id_wali_kelas = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO absensi (id_guru_mapel, id_kelas, tanggal, id_wali_kelas, status_wali_kelas)
            VALUES (:id_guru_mapel, :id_kelas, :tanggal, :id_wali_kelas, 'pending')
        ");
        $stmt->execute([
            'id_guru_mapel' => $id_guru_mapel,
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal,
            'id_wali_kelas' => $id_wali_kelas
        ]);
        return $this->db->lastInsertId();
    }

    public function insertAbsensiDetail($id_absensi, $id_siswa, $status_kehadiran, $keterangan = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO absensi_detail (id_absensi, id_siswa, status_kehadiran, keterangan, status_pengiriman)
            VALUES (:id_absensi, :id_siswa, :status_kehadiran, :keterangan, 'pending')
        ");
        $stmt->execute([
            'id_absensi' => $id_absensi,
            'id_siswa' => $id_siswa,
            'status_kehadiran' => $status_kehadiran,
            'keterangan' => $keterangan
        ]);
    }

    public function absensiSudahAda($id_guru_mapel, $id_kelas, $tanggal)
    {
        $stmt = $this->db->prepare("
            SELECT id_absensi FROM absensi
            WHERE id_guru_mapel = :id_guru_mapel AND id_kelas = :id_kelas AND tanggal = :tanggal
        ");
        $stmt->execute([
            'id_guru_mapel' => $id_guru_mapel,
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRiwayatSiswa($id_siswa)
    {
        $stmt = $this->db->prepare("
            SELECT a.tanggal, ad.status_kehadiran, ad.keterangan, k.nama_kelas, mp.nama_mapel
            FROM absensi_detail ad
            JOIN absensi a ON ad.id_absensi = a.id_absensi
            JOIN kelas k ON a.id_kelas = k.id_kelas
            JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
            JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
            WHERE ad.id_siswa = :id_siswa
            ORDER BY a.tanggal DESC
        ");
        $stmt->execute(['id_siswa' => $id_siswa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsensiPendingByGuru($id_guru)
    {
        $stmt = $this->db->prepare("
            SELECT a.*, k.nama_kelas, mp.nama_mapel
            FROM absensi a
            JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
            JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
            JOIN kelas k ON a.id_kelas = k.id_kelas
            WHERE gm.id_guru = :id_guru
              AND a.status_wali_kelas = 'pending'
            ORDER BY a.tanggal DESC
        ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdGuruMapel($id_guru, $id_mapel)
    {
        $stmt = $this->db->prepare("
            SELECT id_guru_mapel FROM guru_mapel 
            WHERE id_guru = :id_guru AND id_mapel = :id_mapel
        ");
        $stmt->execute([
            ':id_guru' => $id_guru,
            ':id_mapel' => $id_mapel
        ]);
        return $stmt->fetchColumn();
    }

    public function updateStatusWaliKelas($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE absensi SET status_wali_kelas = :status WHERE id_absensi = :id
        ");
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    public function getKelasById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM kelas WHERE id_kelas = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMapelById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mata_pelajaran WHERE id_mapel = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllKelas()
    {
        $stmt = $this->db->query("SELECT * FROM kelas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // PENTING: Fungsi yang digunakan oleh controller
    public function getGuruMapel($id_mapel, $id_kelas, $id_guru)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM guru_mapel 
            WHERE id_mapel = :id_mapel AND id_kelas = :id_kelas AND id_guru = :id_guru
        ");
        $stmt->execute([
            'id_mapel' => $id_mapel,
            'id_kelas' => $id_kelas,
            'id_guru' => $id_guru
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAbsensiPendingForWaliKelas($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT a.*, k.nama_kelas, mp.nama_mapel
        FROM absensi a
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN kelas k ON gm.id_kelas = k.id_kelas
        JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
        WHERE a.status_wali_kelas = 'pending'
          AND a.id_kelas IN (
              SELECT id_kelas FROM wali_kelas WHERE id_guru = :id_guru
          )
        ORDER BY a.tanggal DESC
    ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAbsensiDitolakByGuru($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT a.*, k.nama_kelas, mp.nama_mapel
        FROM absensi a
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
        JOIN kelas k ON a.id_kelas = k.id_kelas
        WHERE gm.id_guru = :id_guru
          AND a.status_wali_kelas = 'ditolak'
        ORDER BY a.tanggal DESC
    ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsensiHariIni($id_siswa)
    {
        $tanggal = date('Y-m-d');

        $stmt = $this->db->prepare("
        SELECT 
            ad.status_kehadiran, 
            ad.keterangan, 
            a.tanggal,
            mp.nama_mapel,
            g.nama_guru AS nama_guru
        FROM absensi_detail ad
        JOIN absensi a ON ad.id_absensi = a.id_absensi
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
        JOIN guru g ON gm.id_guru = g.id_guru
        WHERE ad.id_siswa = :id_siswa
            AND a.tanggal = :tanggal
            AND a.status_wali_kelas = 'disetujui'
            AND ad.status_pengiriman = 'terkirim'
    ");

        $stmt->execute([
            'id_siswa' => $id_siswa,
            'tanggal' => $tanggal
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // BUKAN fetch()
    }




    public function updateStatusPengiriman($id_absensi)
    {
        $db = (new Database())->getConnection();

        $stmt = $db->prepare("UPDATE absensi_detail SET status_pengiriman = 'terkirim' WHERE id_absensi = ?");
        $stmt->execute([$id_absensi]);
    }


    public function getRekapBulananGuruMapel($id_guru, $bulan, $tahun)
    {
        $sql = "
        SELECT 
            k.id_kelas,
            k.nama_kelas,
            mp.id_mapel,
            mp.nama_mapel,
            SUM(CASE WHEN ad.status_kehadiran = 'hadir' THEN 1 ELSE 0 END) AS hadir,
            SUM(CASE WHEN ad.status_kehadiran = 'izin' THEN 1 ELSE 0 END) AS izin,
            SUM(CASE WHEN ad.status_kehadiran = 'sakit' THEN 1 ELSE 0 END) AS sakit,
            SUM(CASE WHEN ad.status_kehadiran = 'alpa' THEN 1 ELSE 0 END) AS alpa
        FROM absensi a
        JOIN absensi_detail ad ON ad.id_absensi = a.id_absensi
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
        JOIN kelas k ON a.id_kelas = k.id_kelas
        WHERE gm.id_guru = :id_guru
          AND MONTH(a.tanggal) = :bulan
          AND YEAR(a.tanggal) = :tahun
          AND a.status_wali_kelas = 'disetujui'
        GROUP BY k.id_kelas, k.nama_kelas, mp.id_mapel, mp.nama_mapel
        ORDER BY k.nama_kelas, mp.nama_mapel
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_guru' => $id_guru,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getRiwayatLengkapGuru($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT 
            a.id_absensi,
            a.tanggal,
            k.nama_kelas,
            m.nama_mapel,
            a.status_wali_kelas
        FROM absensi a
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN kelas k ON gm.id_kelas = k.id_kelas
        JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
        WHERE gm.id_guru = :id_guru
        ORDER BY a.tanggal DESC
    ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getKehadiranHarianByWali($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT 
            s.nama_siswa,
            s.id_kelas,
            k.nama_kelas,
            a.tanggal,
            MAX(
                CASE ad.status_kehadiran
                    WHEN 'alpa' THEN 4
                    WHEN 'sakit' THEN 3
                    WHEN 'izin' THEN 2
                    WHEN 'hadir' THEN 1
                    ELSE 0
                END
            ) AS status_value
        FROM absensi_detail ad
        JOIN absensi a ON ad.id_absensi = a.id_absensi
        JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
        JOIN siswa s ON ad.id_siswa = s.id_siswa
        JOIN kelas k ON s.id_kelas = k.id_kelas
        JOIN wali_kelas wk ON wk.id_kelas = k.id_kelas
        WHERE wk.id_guru = :id_guru
        GROUP BY s.id_siswa, a.tanggal
        ORDER BY a.tanggal DESC, s.nama_siswa
    ");
        $stmt->execute(['id_guru' => $id_guru]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Konversi angka status ke teks
        foreach ($data as &$row) {
            $row['status'] = match ($row['status_value']) {
                4 => 'Alpa',
                3 => 'Sakit',
                2 => 'Izin',
                1 => 'Hadir',
                default => 'Tidak Diketahui'
            };
        }

        return $data;
    }



    public function getRekapBulananByWali($id_guru, $bulan, $tahun)
    {
        // Step 1: Ambil status terburuk per siswa per tanggal
        $stmt = $this->db->prepare("
        SELECT 
            s.id_siswa,
            s.nama_siswa,
            k.nama_kelas,
            a.tanggal,
            MAX(CASE ad.status_kehadiran
                WHEN 'alpa' THEN 4
                WHEN 'sakit' THEN 3
                WHEN 'izin' THEN 2
                WHEN 'hadir' THEN 1
                ELSE 0
            END) AS status_value
        FROM siswa s
        JOIN kelas k ON s.id_kelas = k.id_kelas
        JOIN wali_kelas wk ON wk.id_kelas = k.id_kelas
        JOIN absensi_detail ad ON ad.id_siswa = s.id_siswa
        JOIN absensi a ON a.id_absensi = ad.id_absensi
        WHERE wk.id_guru = :id_guru
          AND MONTH(a.tanggal) = :bulan
          AND YEAR(a.tanggal) = :tahun
        GROUP BY s.id_siswa, a.tanggal
    ");
        $stmt->execute([
            'id_guru' => $id_guru,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Step 2: Rekap per siswa
        $rekap = [];
        foreach ($data as $row) {
            $id = $row['id_siswa'];

            if (!isset($rekap[$id])) {
                $rekap[$id] = [
                    'nama_siswa' => $row['nama_siswa'],
                    'nama_kelas' => $row['nama_kelas'],
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0
                ];
            }

            switch ($row['status_value']) {
                case 4:
                    $rekap[$id]['alpa']++;
                    break;
                case 3:
                    $rekap[$id]['sakit']++;
                    break;
                case 2:
                    $rekap[$id]['izin']++;
                    break;
                case 1:
                    $rekap[$id]['hadir']++;
                    break;
            }
        }

        return array_values($rekap);
    }



    public function getAbsensiByTanggal($id_siswa, $tanggal)
    {
        $stmt = $this->db->prepare("
        SELECT a.tanggal, mp.nama_mapel, g.nama_guru, ad.status_kehadiran, ad.keterangan
        FROM absensi_detail ad
        JOIN absensi a ON a.id_absensi = ad.id_absensi
        JOIN guru_mapel gm ON gm.id_guru_mapel = a.id_guru_mapel
        JOIN guru g ON g.id_guru = gm.id_guru
        JOIN mata_pelajaran mp ON mp.id_mapel = gm.id_mapel
        WHERE ad.id_siswa = :id_siswa
        AND a.tanggal = :tanggal
        ORDER BY a.tanggal DESC
    ");
        $stmt->execute(['id_siswa' => $id_siswa, 'tanggal' => $tanggal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
