<?php
require_once __DIR__ . '/../../core/Database.php';

class MapelModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    // Ambil semua data mapel
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil satu data berdasarkan ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mata_pelajaran WHERE id_mapel = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert data baru
    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO mata_pelajaran (nama_mapel, kode_mapel) VALUES (:nama_mapel, :kode_mapel)");
        return $stmt->execute([
            'nama_mapel' => $data['nama_mapel'],
            'kode_mapel' => $data['kode_mapel']
        ]);
    }

    // Update data berdasarkan ID
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE mata_pelajaran SET nama_mapel = :nama_mapel, kode_mapel = :kode_mapel WHERE id_mapel = :id");
        return $stmt->execute([
            'id' => $id,
            'nama_mapel' => $data['nama_mapel'],
            'kode_mapel' => $data['kode_mapel']
        ]);
    }

    // Hapus data berdasarkan ID (✅ diperbaiki nama tabel)
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM mata_pelajaran WHERE id_mapel = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Cek apakah kode mapel sudah ada (untuk validasi saat import)
    public function existsByKode($kode)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM mata_pelajaran WHERE kode_mapel = ?");
        $stmt->execute([$kode]);
        return $stmt->fetchColumn() > 0;
    }


    public function isUsedInGuruMapel($id_mapel)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM guru_mapel WHERE id_mapel = ?");
        $stmt->execute([$id_mapel]);
        return $stmt->fetchColumn() > 0;
    }
}
