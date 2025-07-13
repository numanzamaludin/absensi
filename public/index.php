<?php
session_start();


// Atur zona waktu ke WIB (Asia/Jakarta)
date_default_timezone_set('Asia/Jakarta');



require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/helpers/AuthHelper.php'; // tambahkan ini
require_once __DIR__ . '/../app/controllers/RekapController.php';



$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Halaman yang tidak butuh login
$publicPages = ['login', 'do_login'];

// Cek login terlebih dahulu
if (!in_array($page, $publicPages)) {
    require_login(); // redirect jika belum login
}

switch ($page) {
    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'do_login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->doLogin();
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/../app/controllers/DashboardController.php';
        (new DashboardController())->index();
        break;

    case 'proses_edit_absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->prosesEdit();
        break;






    // Absensi
    case 'dashboard':
        include 'views/dashboard_guru.php';
        break;

    case 'absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->form();
        break;

    case 'simpan_absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->simpan();
        break;

    case 'persetujuan_absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        $controller = new AbsensiController();
        $controller->persetujuan();
        break;

    case 'detail_absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->detail();
        break;

    case 'edit_absensi':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php'; // ✅ Path benar
        $controller = new AbsensiController();
        $controller->edit();
        break;



    case 'rekap':
        require_once __DIR__ . '/../app/controllers/RekapController.php';
        $controller = new RekapController();
        $controller->index();
        break;



    case 'riwayat_absensi':
        require_once '../app/controllers/AbsensiController.php';
        $controller = new AbsensiController();
        $controller->riwayatGuru(); // method baru
        break;








    case 'rekap_bulanan_wali':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->rekapBulananWali();
        break;






    case 'rekap_bulanan_guru':
        require_once __DIR__ . '/../app/controllers/AbsensiController.php';
        (new AbsensiController())->rekapBulananGuru();
        break;


    // Guru
    case 'guru_index':
    case 'guru_tambah':
    case 'guru_edit':
    case 'guru_hapus':
        require_once __DIR__ . '/../app/controllers/GuruController.php';
        $controller = new GuruController();
        if ($page === 'guru_index') $controller->index();
        elseif ($page === 'guru_tambah') $controller->tambah();
        elseif ($page === 'guru_edit') $controller->edit();
        elseif ($page === 'guru_hapus') $controller->hapus();
        break;

    // Kelas
    case 'kelas_index':
    case 'kelas_tambah':
    case 'kelas_edit':
    case 'kelas_hapus':
        require_once __DIR__ . '/../app/controllers/KelasController.php';
        $controller = new KelasController();
        if ($page === 'kelas_index') $controller->index();
        elseif ($page === 'kelas_tambah') $controller->tambah();
        elseif ($page === 'kelas_edit') $controller->edit();
        elseif ($page === 'kelas_hapus') $controller->hapus();
        break;

    // Siswa
    case 'siswa_index':
    case 'siswa_tambah':
    case 'siswa_edit':
    case 'siswa_hapus':
        require_once __DIR__ . '/../app/controllers/SiswaController.php';
        $controller = new SiswaController();
        if ($page === 'siswa_index') $controller->index();
        elseif ($page === 'siswa_tambah') $controller->tambah();
        elseif ($page === 'siswa_edit') $controller->edit();
        elseif ($page === 'siswa_hapus') $controller->hapus();
        break;

    // Mapel
    case 'mapel_index':
    case 'mapel_tambah':
    case 'mapel_edit':
    case 'mapel_hapus':
        require_once __DIR__ . '/../app/controllers/MapelController.php';
        $controller = new MapelController();
        if ($page === 'mapel_index') $controller->index();
        elseif ($page === 'mapel_tambah') $controller->tambah();
        elseif ($page === 'mapel_edit') $controller->edit();
        elseif ($page === 'mapel_hapus') $controller->hapus();
        break;

    // Guru Mapel
    case 'guru_mapel_index':
    case 'guru_mapel_tambah':
    case 'guru_mapel_edit':
    case 'guru_mapel_hapus':
        require_once __DIR__ . '/../app/controllers/GuruMapelController.php';
        $controller = new GuruMapelController();
        if ($page === 'guru_mapel_index') $controller->index();
        elseif ($page === 'guru_mapel_tambah') $controller->tambah();
        elseif ($page === 'guru_mapel_edit') $controller->edit();
        elseif ($page === 'guru_mapel_hapus') $controller->hapus();
        break;

    // Wali Kelas
    case 'wali_kelas_index':
    case 'wali_kelas_tambah':
    case 'wali_kelas_edit':
    case 'wali_kelas_hapus':
        require_once __DIR__ . '/../app/controllers/WaliKelasController.php';
        $controller = new WaliKelasController();
        if ($page === 'wali_kelas_index') $controller->index();
        elseif ($page === 'wali_kelas_tambah') $controller->tambah();
        elseif ($page === 'wali_kelas_edit') $controller->edit();
        elseif ($page === 'wali_kelas_hapus') $controller->hapus();
        break;

    // Jadwal
    case 'jadwal':
    case 'jadwal-create':
    case 'jadwal-store':
    case 'jadwal-edit':
    case 'jadwal-update':
    case 'jadwal-delete':
        require_once __DIR__ . '/../app/controllers/JadwalController.php';
        $controller = new JadwalController();
        if ($page === 'jadwal') $controller->index();
        elseif ($page === 'jadwal-create') $controller->create();
        elseif ($page === 'jadwal-store') $controller->store();
        elseif ($page === 'jadwal-edit') $controller->edit();
        elseif ($page === 'jadwal-update') $controller->update();
        elseif ($page === 'jadwal-delete') $controller->delete();
        break;

    // Import Siswa (dibatasi untuk admin)
    case 'import_siswa':
        require_login('admin');
        require_once __DIR__ . '/../app/views/import_siswa.php';
        break;

    case 'proses_import_siswa':
        require_login('admin');
        require_once __DIR__ . '/../app/controllers/ImportSiswaController.php';
        (new ImportSiswaController())->import();
        break;

    case 'download_template_siswa':
        require_login('admin');
        require_once __DIR__ . '/../app/controllers/ImportSiswaController.php';
        (new ImportSiswaController())->downloadTemplate();
        break;








    case 'rekap_excel_style':
        require_once __DIR__ . '/../app/controllers/RekapController.php';
        (new RekapController())->rekapBulananExcelStyle();
        break;

    case 'rekap_kehadiran_harian':
        require_once __DIR__ . '/../app/controllers/RekapController.php';
        (new RekapController())->rekapKehadiranHarian();
        break;



    case 'ajax_rekap_excel':
        require_once __DIR__ . '/../app/controllers/RekapController.php';
        $rekapController = new RekapController(); // 🟢 PENTING: harus ada ini
        $rekapController->ajaxRekapBulananExcel(); // baris 264
        break;


    case 'detail_rekap_siswa':
        $controller = new RekapController();
        $controller->detailRekapSiswa();
        break;



    case 'export_rekap_excel':
        (new RekapController())->exportRekapBulanan('xls');
        break;

    case 'export_rekap_pdf':
        (new RekapController())->exportRekapBulanan('pdf');
        break;

    case 'export_rekap_csv':
        (new RekapController())->exportRekapBulanan('csv');
        break;

    case 'export_harian':
        (new RekapController())->exportKehadiranHarian();
        break;

    case 'export_detail_mapel':
        (new RekapController())->exportDetailMapel();
        break;

    // Contoh di index.php
    case 'ajax_riwayat_absensi':
        require_once __DIR__ . '/../app/controllers/SiswaController.php';
        $controller = new SiswaController();
        $controller->ajaxRiwayatAbsensi();
        break;


    // index.php
    case 'ajax_rekap_harian':
        $rekapController = new RekapController();
        $rekapController->ajaxRekapKehadiranHarian();
        break;



    default:
        echo "404 - Halaman tidak ditemukan.";
        break;
}
