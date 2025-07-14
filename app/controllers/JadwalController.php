<?php

require_once __DIR__ . '/../../core/Database.php';

class JadwalController
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function index()
    {
        $stmt = $this->conn->query("
            SELECT j.*, g.nama_guru, m.nama_mapel, k.nama_kelas
            FROM jadwal j
            JOIN guru_mapel gm ON j.id_guru_mapel = gm.id_guru_mapel
            JOIN guru g ON gm.id_guru = g.id_guru
            JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
            JOIN kelas k ON gm.id_kelas = k.id_kelas
        ");
        $jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/jadwal/index.php';
    }

    public function create()
    {
        $guruMapel = $this->conn->query("
            SELECT gm.id_guru_mapel, g.nama_guru, m.nama_mapel, k.nama_kelas
            FROM guru_mapel gm
            JOIN guru g ON gm.id_guru = g.id_guru
            JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
            JOIN kelas k ON gm.id_kelas = k.id_kelas
        ")->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/jadwal/tambah.php';
    }

    public function store()
    {
        $stmt = $this->conn->prepare("
            INSERT INTO jadwal (id_guru_mapel, hari, jam_mulai, jam_selesai)
            VALUES (:id_guru_mapel, :hari, :jam_mulai, :jam_selesai)
        ");

        $stmt->execute([
            ':id_guru_mapel' => $_POST['id_guru_mapel'],
            ':hari' => $_POST['hari'],
            ':jam_mulai' => $_POST['jam_mulai'],
            ':jam_selesai' => $_POST['jam_selesai'],
        ]);

        header('Location: index.php?page=jadwal');
        exit;
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            echo "ID tidak ditemukan.";
            exit;
        }

        $id = $_GET['id'];

        $stmt = $this->conn->prepare("SELECT * FROM jadwal WHERE id_jadwal = :id");
        $stmt->execute([':id' => $id]);
        $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);

        $guruMapel = $this->conn->query("
            SELECT gm.id_guru_mapel, g.nama_guru, m.nama_mapel, k.nama_kelas
            FROM guru_mapel gm
            JOIN guru g ON gm.id_guru = g.id_guru
            JOIN mata_pelajaran m ON gm.id_mapel = m.id_mapel
            JOIN kelas k ON gm.id_kelas = k.id_kelas
        ")->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/jadwal/edit.php';
    }

    public function update()
    {
        if (!isset($_POST['id'])) {
            echo "ID tidak ditemukan.";
            exit;
        }

        $id = $_POST['id'];

        $stmt = $this->conn->prepare("
            UPDATE jadwal
            SET id_guru_mapel = :id_guru_mapel,
                hari = :hari,
                jam_mulai = :jam_mulai,
                jam_selesai = :jam_selesai
            WHERE id_jadwal = :id
        ");

        $stmt->execute([
            ':id' => $id,
            ':id_guru_mapel' => $_POST['id_guru_mapel'],
            ':hari' => $_POST['hari'],
            ':jam_mulai' => $_POST['jam_mulai'],
            ':jam_selesai' => $_POST['jam_selesai'],
        ]);

        header('Location: index.php?page=jadwal');
        exit;
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            echo "ID tidak ditemukan.";
            exit;
        }

        $id = $_GET['id'];

        $stmt = $this->conn->prepare("DELETE FROM jadwal WHERE id_jadwal = :id");
        $stmt->execute([':id' => $id]);

        header('Location: index.php?page=jadwal');
        exit;
    }
}
