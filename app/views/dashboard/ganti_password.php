<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../core/Database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$db = (new Database())->getConnection();
$userId = $_SESSION['user']['id_guru'];

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi = $_POST['konfirmasi'] ?? '';

    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi)) {
        $errors[] = "Semua field wajib diisi.";
    } elseif ($password_baru !== $konfirmasi) {
        $errors[] = "Password baru dan konfirmasi tidak cocok.";
    } else {
        $stmt = $db->prepare("SELECT password FROM guru WHERE id_guru = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password_lama, $user['password'])) {
            $errors[] = "Password lama salah.";
        } else {
            $hashBaru = password_hash($password_baru, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE guru SET password = :pass WHERE id_guru = :id");
            if ($stmt->execute(['pass' => $hashBaru, 'id' => $userId])) {
                $success = "Password berhasil diubah.";
            } else {
                $errors[] = "Gagal mengubah password.";
            }
        }
    }
}

// Tampilkan view
include __DIR__ . '/ganti_password_view.php';
