<?php
require_once __DIR__ . '/../../core/Database.php';

class SiswaModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT siswa.*, kelas.nama_kelas 
            FROM siswa 
            LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
            ORDER BY siswa.nama_siswa ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM siswa WHERE id_siswa = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO siswa (nama_siswa, nis, email, password, id_kelas)
            VALUES (:nama_siswa, :nis, :email, :password, :id_kelas)
        ");
        return $stmt->execute([
            'nama_siswa' => $data['nama_siswa'],
            'nis' => $data['nis'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'id_kelas' => $data['id_kelas']
        ]);
    }

    public function update($id, $data)
    {
        $query = "
            UPDATE siswa 
            SET nama_siswa = :nama_siswa, nis = :nis, email = :email, id_kelas = :id_kelas";

        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id_siswa = :id";

        $stmt = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'nama_siswa' => $data['nama_siswa'],
            'nis' => $data['nis'],
            'email' => $data['email'],
            'id_kelas' => $data['id_kelas']
        ];

        if (!empty($data['password'])) {
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM siswa WHERE id_siswa = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Ambil semua kelas (untuk dropdown)
    public function getAllKelas()
    {
        $stmt = $this->db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function updateKelasBulk(array $ids, $kelasBaru)
    {
        if (empty($ids)) return;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE siswa SET id_kelas = ? WHERE id_siswa IN ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge([$kelasBaru], $ids));
    }







    public function getByKelas($id_kelas)
    {
        $stmt = $this->db->prepare("
        SELECT siswa.*, kelas.nama_kelas 
        FROM siswa 
        LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
        WHERE siswa.id_kelas = :id_kelas
        ORDER BY siswa.nama_siswa ASC
    ");
        $stmt->execute(['id_kelas' => $id_kelas]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
