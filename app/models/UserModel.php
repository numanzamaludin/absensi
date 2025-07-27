<?php
require_once __DIR__ . '/../../core/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getUserByEmail($email)
    {
        // Cek admin
        $stmt = $this->db->prepare("SELECT id_admin AS id, email, nama_admin AS nama, password, 'admin' AS role FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) return $admin;

        // Cek guru
        $stmt = $this->db->prepare("SELECT id_guru, email, nama_guru AS nama, password, 'guru' AS role FROM guru WHERE email = ?");
        $stmt->execute([$email]);
        $guru = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($guru) {
            $guru['id'] = $guru['id_guru']; // Tambahkan 'id' agar konsisten dengan session
            return $guru;
        }

        // Cek siswa
        $stmt = $this->db->prepare("SELECT id_siswa AS id, email, nama_siswa AS nama, password, 'siswa' AS role FROM siswa WHERE email = ?");
        $stmt->execute([$email]);
        $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($siswa) return $siswa;

        return null;
    }

    public function insertSiswa($nama, $email, $nis, $password, $id_kelas)
    {
        $stmt = $this->db->prepare("INSERT INTO siswa (nama_siswa, email, nis, password, id_kelas) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $email, $nis, password_hash($password, PASSWORD_BCRYPT), $id_kelas]);
    }
}
