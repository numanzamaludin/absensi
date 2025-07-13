<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../core/Database.php';

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika sudah login, langsung ke dashboard
        if (isset($_SESSION['user'])) {
            header("Location: ?page=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public function doLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'email'    => $user['email'],
                    'nama'     => $user['nama'],
                    'role'     => $user['role'],
                    'id_guru'  => $user['role'] === 'guru' ? $user['id_guru'] : null,
                    'id_siswa' => $user['role'] === 'siswa' ? $user['id'] : null,
                    'id_admin' => $user['role'] === 'admin' ? $user['id'] : null
                ];

                header("Location: ?page=dashboard");
                exit;
            } else {
                $error = "Email atau password salah.";
                require_once __DIR__ . '/../views/login.php';
            }
        } else {
            echo "Akses tidak valid.";
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        header("Location: ?page=login");
        exit;
    }
}
