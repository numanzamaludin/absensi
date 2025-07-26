<?php
require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        // Non-cache headers
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $role = $_SESSION['user']['role'];
        $dashboardModel = new DashboardModel();

        if ($role === 'admin') {
            $data = $dashboardModel->getAdminStats();
            require_once __DIR__ . '/../views/dashboard/admin.php';
        } elseif ($role === 'guru') {
            $guruId = $_SESSION['user']['id_guru'];

            // Mapel dan Kelas
            $mapel = $dashboardModel->getMapelByGuru($guruId);
            $kelasList = $dashboardModel->getKelasByGuru($guruId);

            // Cek Wali Kelas
            $isWaliKelas = $dashboardModel->isWaliKelas($guruId);
            $kelasWali = $dashboardModel->getKelasWali($guruId);

            // Absensi
            $absensiPendingGuru = $dashboardModel->getAbsensiPendingByGuru($guruId);
            $absensiDitolak = $dashboardModel->getAbsensiDitolakByGuru($guruId);


            // ✅ Tambahkan Jadwal
            require_once __DIR__ . '/../models/JadwalModel.php';
            $jadwalModel = new JadwalModel();
            $jadwal = $jadwalModel->getJadwalByGuru($guruId);


            // Jika wali kelas, ambil yang perlu disetujui
            $absensiPendingWali = $isWaliKelas
                ? $dashboardModel->getAbsensiPendingForWaliKelas($guruId)
                : [];

            require_once __DIR__ . '/../views/dashboard/guru.php';
        } elseif ($role === 'siswa') {
            require_once __DIR__ . '/../views/dashboard/siswa.php';
        } else {
            echo "Role tidak dikenali.";
        }
    }
}
