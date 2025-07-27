<?php
require_once __DIR__ . '/../../core/Database.php';

class DashboardModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Statistik admin
    public function getAdminStats()
    {
        $stats = [];
        $stats['jumlah_guru'] = $this->countTable('guru');
        $stats['jumlah_siswa'] = $this->countTable('siswa');
        $stats['jumlah_kelas'] = $this->countTable('kelas');
        $stats['jumlah_mapel'] = $this->countTable('mata_pelajaran');
        return $stats;
    }

    private function countTable($table)
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) AS total FROM $table");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("DB Error (countTable): " . $e->getMessage());
            return 0;
        }
    }

    public function getMapelByGuru($idGuru)
    {
        try {
            $sql = "SELECT mp.* 
                    FROM guru_mapel gm
                    JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
                    WHERE gm.id_guru = :idGuru";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['idGuru' => $idGuru]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getMapelByGuru): " . $e->getMessage());
            return [];
        }
    }

    public function getKelasByGuru($idGuru)
    {
        try {
            $sql = "SELECT DISTINCT k.*
                    FROM guru_mapel gm
                    JOIN kelas k ON gm.id_kelas = k.id_kelas
                    WHERE gm.id_guru = :idGuru";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['idGuru' => $idGuru]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getKelasByGuru): " . $e->getMessage());
            return [];
        }
    }

    public function isWaliKelas($idGuru)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM wali_kelas WHERE id_guru = :idGuru");
            $stmt->execute(['idGuru' => $idGuru]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] > 0;
        } catch (PDOException $e) {
            error_log("DB Error (isWaliKelas): " . $e->getMessage());
            return false;
        }
    }

    public function getKelasWali($idGuru)
    {
        try {
            $sql = "SELECT k.* 
                    FROM wali_kelas w
                    JOIN kelas k ON w.id_kelas = k.id_kelas
                    WHERE w.id_guru = :idGuru";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['idGuru' => $idGuru]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getKelasWali): " . $e->getMessage());
            return [];
        }
    }

    // ✅ Tambahkan ini untuk absensi pending dari guru (bukan wali kelas)
    public function getAbsensiPendingByGuru($idGuru)
    {
        try {
            $sql = "SELECT a.*, k.nama_kelas, mp.nama_mapel
                    FROM absensi a
                    JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
                    JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
                    JOIN kelas k ON a.id_kelas = k.id_kelas
                    WHERE gm.id_guru = :idGuru
                      AND a.status_wali_kelas = 'pending'
                    ORDER BY a.tanggal DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['idGuru' => $idGuru]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getAbsensiPendingByGuru): " . $e->getMessage());
            return [];
        }
    }

    // Untuk wali kelas
    public function getAbsensiPendingForWaliKelas($guruId)
    {
        try {
            $sql = "SELECT a.*, k.nama_kelas, mp.nama_mapel
                    FROM absensi a
                    JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
                    JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
                    JOIN kelas k ON a.id_kelas = k.id_kelas
                    JOIN wali_kelas w ON w.id_kelas = k.id_kelas
                    WHERE w.id_guru = :guruId
                      AND (a.status_wali_kelas IS NULL OR a.status_wali_kelas = 'pending')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['guruId' => $guruId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getAbsensiPendingForWaliKelas): " . $e->getMessage());
            return [];
        }
    }

    public function getAbsensiDitolakByGuru($guruId)
    {
        try {
            $sql = "SELECT a.*, k.nama_kelas, mp.nama_mapel
                    FROM absensi a
                    JOIN guru_mapel gm ON a.id_guru_mapel = gm.id_guru_mapel
                    JOIN mata_pelajaran mp ON gm.id_mapel = mp.id_mapel
                    JOIN kelas k ON a.id_kelas = k.id_kelas
                    WHERE gm.id_guru = :guruId
                      AND a.status_wali_kelas = 'ditolak'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['guruId' => $guruId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getAbsensiDitolakByGuru): " . $e->getMessage());
            return [];
        }
    }

    public function getGuruMapelId($id_guru, $id_mapel)
    {
        try {
            $stmt = $this->db->prepare("SELECT id_guru_mapel FROM guru_mapel WHERE id_guru = ? AND id_mapel = ?");
            $stmt->execute([$id_guru, $id_mapel]);
            $result = $stmt->fetch();
            return $result['id_guru_mapel'] ?? null;
        } catch (PDOException $e) {
            error_log("DB Error (getGuruMapelId): " . $e->getMessage());
            return null;
        }
    }
}
