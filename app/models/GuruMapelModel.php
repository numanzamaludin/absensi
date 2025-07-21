<?php
require_once __DIR__ . '/../../core/Database.php';

class GuruMapelModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
        SELECT gm.*, g.nama_guru, m.nama_mapel, k.nama_kelas
        FROM guru_mapel gm
        JOIN guru g ON gm.id_guru = g.id_guru
        JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
        JOIN kelas k ON gm.id_kelas = k.id_kelas
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM guru_mapel WHERE id_guru_mapel = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO guru_mapel (id_guru, id_mapel, id_kelas) VALUES (:id_guru, :id_mapel, :id_kelas)");
        return $stmt->execute([
            'id_guru' => $data['id_guru'],
            'id_mapel' => $data['id_mapel'],
            'id_kelas' => $data['id_kelas']
        ]);
    }



    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE guru_mapel SET id_guru = ?, id_mapel = ?, id_kelas = ? WHERE id_guru_mapel = ?");
        return $stmt->execute([
            $data['id_guru'],
            $data['id_mapel'],
            $data['id_kelas'],
            $id
        ]);
    }


    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM guru_mapel WHERE id_guru_mapel = :id");
        return $stmt->execute(['id' => $id]);
    }




    public function getKelasByGuru($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT DISTINCT k.id_kelas, k.nama_kelas
        FROM guru_mapel gm
        JOIN kelas k ON k.id_kelas = gm.id_kelas
        WHERE gm.id_guru = :id_guru
    ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function isUsedInAbsensi($id_guru_mapel)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM absensi WHERE id_guru_mapel = ?");
        $stmt->execute([$id_guru_mapel]);
        return $stmt->fetchColumn() > 0;
    }
}
