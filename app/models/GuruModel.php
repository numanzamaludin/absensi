<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/absensi/core/Database.php';

class GuruModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM guru ORDER BY nama_guru ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM guru WHERE id_guru = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO guru (nama_guru, email, nip, password)
            VALUES (:nama_guru, :email, :nip, :password)
        ");
        return $stmt->execute([
            'nama_guru' => $data['nama_guru'],
            'email'     => $data['email'],
            'nip'       => $data['nip'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public function update($id, $data)
    {
        $query = "UPDATE guru SET nama_guru = :nama_guru, email = :email, nip = :nip";
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }
        $query .= " WHERE id_guru = :id";

        $stmt = $this->db->prepare($query);

        $params = [
            'id'         => $id,
            'nama_guru'  => $data['nama_guru'],
            'email'      => $data['email'],
            'nip'        => $data['nip']
        ];

        if (!empty($data['password'])) {
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM guru WHERE id_guru = :id");
        return $stmt->execute(['id' => $id]);
    }
}
