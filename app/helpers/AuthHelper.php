<?php
// app/helpers/AuthHelper.php

/**
 * Fungsi ini memastikan bahwa user sudah login sebelum mengakses halaman tertentu.
 * Jika parameter $role diberikan, maka fungsi juga akan memeriksa apakah role user sesuai.
 *
 * @param string|null $role Role yang diizinkan ('admin', 'guru', 'siswa') atau null jika semua boleh
 */
function require_login($role = null)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Cek apakah sudah login
    if (!isset($_SESSION['user'])) {
        header("Location: ?page=login");
        exit;
    }

    // Jika peran tidak sesuai, tampilkan pesan akses ditolak
    if ($role !== null && $_SESSION['user']['role'] !== $role) {
        echo "<h3 style='color:red;'>Akses ditolak. Halaman ini hanya untuk <strong>$role</strong>.</h3>";
        exit;
    }
}

/**
 * Fungsi ini hanya mengecek apakah user sudah login (tanpa redirect).
 * Bisa digunakan untuk tampilan conditional.
 *
 * @return bool
 */
function is_logged_in()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['user']);
}

/**
 * Fungsi ini mengambil data user aktif dari sesi.
 *
 * @return array|null
 */
function current_user()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['user'] ?? null;
}
