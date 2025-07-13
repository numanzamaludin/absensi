<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi2/core/Database.php';

class MapelModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM mata_pelajaran WHERE id_mapel = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO mata_pelajaran (nama_mapel, kode_mapel) VALUES (:nama_mapel, :kode_mapel)");
        return $stmt->execute([
            'nama_mapel' => $data['nama_mapel'],
            'kode_mapel' => $data['kode_mapel']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE mata_pelajaran SET nama_mapel = :nama_mapel, kode_mapel = :kode_mapel WHERE id_mapel = :id");
        return $stmt->execute([
            'id' => $id,
            'nama_mapel' => $data['nama_mapel'],
            'kode_mapel' => $data['kode_mapel']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mapel WHERE id_mapel = :id");
        return $stmt->execute(['id' => $id]);
    }
}
