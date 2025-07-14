<?php
require_once __DIR__ . '/../../core/Database.php';

class KelasModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM kelas WHERE id_kelas = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO kelas (nama_kelas) VALUES (:nama_kelas)");
        return $stmt->execute(['nama_kelas' => $data['nama_kelas']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE kelas SET nama_kelas = :nama_kelas WHERE id_kelas = :id");
        return $stmt->execute([
            'id' => $id,
            'nama_kelas' => $data['nama_kelas']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM kelas WHERE id_kelas = :id");
        return $stmt->execute(['id' => $id]);
    }







    public function getKelasByWali($id_guru)
    {
        $stmt = $this->db->prepare("SELECT * FROM kelas WHERE id_wali_kelas = :id");
        $stmt->execute(['id' => $id_guru]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
