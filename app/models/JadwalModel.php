<?php
require_once __DIR__ . '/../../core/Database.php';

class JadwalModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT j.*, g.nama_guru, k.nama_kelas, m.nama_mapel 
                                  FROM jadwal j
                                  JOIN guru g ON j.id_guru = g.id_guru
                                  JOIN kelas k ON j.id_kelas = k.id_kelas
                                  JOIN mata_pelajaran m ON j.id_mapel = m.id_mapel");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM jadwal WHERE id_jadwal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO jadwal (id_guru, id_kelas, id_mapel, hari, jam_mulai, jam_selesai)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_guru'],
            $data['id_kelas'],
            $data['id_mapel'],
            $data['hari'],
            $data['jam_mulai'],
            $data['jam_selesai']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE jadwal SET id_guru = ?, id_kelas = ?, id_mapel = ?, hari = ?, jam_mulai = ?, jam_selesai = ?
                                    WHERE id_jadwal = ?");
        return $stmt->execute([
            $data['id_guru'],
            $data['id_kelas'],
            $data['id_mapel'],
            $data['hari'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM jadwal WHERE id_jadwal = ?");
        return $stmt->execute([$id]);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO jadwal (id_guru, id_kelas, id_mapel, hari, jam_mulai, jam_selesai)
        VALUES (:id_guru, :id_kelas, :id_mapel, :hari, :jam_mulai, :jam_selesai)
    ");
        return $stmt->execute([
            'id_guru' => $data['id_guru'],
            'id_kelas' => $data['id_kelas'],
            'id_mapel' => $data['id_mapel'],
            'hari' => $data['hari'],
            'jam_mulai' => $data['jam_mulai'],
            'jam_selesai' => $data['jam_selesai'],
        ]);
    }

    public function findByGuruMapelHariJam($id_guru, $id_mapel, $id_kelas, $hari, $jam)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM jadwal
        WHERE id_guru = :id_guru
          AND id_mapel = :id_mapel
          AND id_kelas = :id_kelas
          AND hari = :hari
          AND :jam BETWEEN jam_mulai AND jam_selesai
        LIMIT 1
    ");
        $stmt->execute([
            'id_guru' => $id_guru,
            'id_mapel' => $id_mapel,
            'id_kelas' => $id_kelas,
            'hari' => $hari,
            'jam' => $jam,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdByGuruMapelKelas($id_guru, $id_mapel, $id_kelas)
    {
        $stmt = $this->db->prepare("SELECT id_guru_mapel FROM guru_mapel 
                                WHERE id_guru = ? AND id_mapel = ? AND id_kelas = ?");
        $stmt->execute([$id_guru, $id_mapel, $id_kelas]);
        return $stmt->fetchColumn(); // hasil id_guru_mapel
    }



    public function getJadwalByGuru($id_guru)
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
        SELECT 
            j.hari, 
            j.jam_mulai, 
            j.jam_selesai, 
            k.nama_kelas, 
            m.nama_mapel
        FROM jadwal j
        JOIN guru_mapel gm ON j.id_guru_mapel = gm.id_guru_mapel
        JOIN kelas k ON gm.id_kelas = k.id_kelas
        JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
        WHERE gm.id_guru = :id_guru
        ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), j.jam_mulai
    ");

        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
