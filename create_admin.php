<?php
require_once __DIR__ . '/core/Database.php';

$db = (new Database())->getConnection();

$nama_admin = "Admin Satria";
$email = "Satriakm@gmail.com";
$password = password_hash("Admin@20208404", PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO admin (nama_admin, email, password) VALUES (:nama_admin, :email, :password)");
$stmt->execute([
    'nama_admin' => $nama_admin,
    'email' => $email,
    'password' => $password
]);

echo "Admin berhasil ditambahkan!";
