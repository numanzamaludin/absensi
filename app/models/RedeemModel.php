<?php
require_once __DIR__ . '/../../core/Database.php';

class RedeemModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Menyimpan akun baru ke dalam tabel akun_email.
     * Kolom kelas hanya diisi jika role adalah 'siswa'.
     */
    public function insertAkun($nama, $email, $role, $kelas = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO akun_email (nama, email, role, kelas, created_at)
            VALUES (:nama, :email, :role, :kelas, NOW())
        ");

        return $stmt->execute([
            ':nama'  => $nama,
            ':email' => $email,
            ':role'  => $role,
            ':kelas' => $kelas,
        ]);
    }

    /**
     * Mengecek apakah email sudah digunakan.
     */
    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT 1 FROM akun_email WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Mengambil semua akun untuk keperluan export.
     */
    public function getAllAkun()
    {
        $stmt = $this->db->query("
        SELECT id, nama, email, role, kelas 
        FROM akun_email 
        ORDER BY role ASC, nama ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM akun_email WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAkun($id, $nama, $role, $kelas = null)
    {
        $stmt = $this->db->prepare("
        UPDATE akun_email 
        SET nama = :nama, role = :role, kelas = :kelas 
        WHERE id = :id
    ");
        return $stmt->execute([
            ':id' => $id,
            ':nama' => $nama,
            ':role' => $role,
            ':kelas' => $kelas
        ]);
    }

    public function deleteAkun($id)
    {
        $stmt = $this->db->prepare("DELETE FROM akun_email WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
