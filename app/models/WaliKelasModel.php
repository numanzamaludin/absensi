<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi2/core/Database.php';

class WaliKelasModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT wk.*, g.nama_guru, k.nama_kelas
            FROM wali_kelas wk
            JOIN guru g ON wk.id_guru = g.id_guru
            JOIN kelas k ON wk.id_kelas = k.id_kelas
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM wali_kelas WHERE id_wali_kelas = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO wali_kelas (id_guru, id_kelas) 
            VALUES (:id_guru, :id_kelas)
        ");
        return $stmt->execute([
            'id_guru' => $data['id_guru'],
            'id_kelas' => $data['id_kelas']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE wali_kelas 
            SET id_guru = :id_guru, id_kelas = :id_kelas 
            WHERE id_wali_kelas = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'id_guru' => $data['id_guru'],
            'id_kelas' => $data['id_kelas']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM wali_kelas WHERE id_wali_kelas = :id");
        return $stmt->execute(['id' => $id]);
    }





    public function getKelasByGuru($id_guru)
    {
        $stmt = $this->db->prepare("
        SELECT k.id_kelas, k.nama_kelas
        FROM wali_kelas wk
        JOIN kelas k ON k.id_kelas = wk.id_kelas
        WHERE wk.id_guru = :id_guru
    ");
        $stmt->execute(['id_guru' => $id_guru]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
