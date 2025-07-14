<?php

class ExportHelper
{
    public function export($siswaList, $kelasInfo, $bulan, $tahun, $format)
    {
        $filename = "rekap_{$kelasInfo['nama_kelas']}_{$bulan}_{$tahun}";

        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $headers = ['NO', 'NIS', 'NAMA'];
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $headers[] = $i;
        }

        $rows = [];
        foreach ($siswaList as $i => $siswa) {
            $row = [
                $i + 1,
                $siswa['nis'],
                $siswa['nama_siswa']
            ];
            for ($d = 1; $d <= $jumlahHari; $d++) {
                $row[] = $siswa['kehadiran'][$d] ?? '-';
            }
            $rows[] = $row;
        }

        switch ($format) {
            case 'csv':
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=$filename.csv");
                $f = fopen('php://output', 'w');
                fputcsv($f, $headers);
                foreach ($rows as $row) {
                    fputcsv($f, $row);
                }
                fclose($f);
                break;

            case 'xls':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$filename.xls");
                echo "<table border='1'><tr>";
                foreach ($headers as $header) {
                    echo "<th>$header</th>";
                }
                echo "</tr>";
                foreach ($rows as $row) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>$cell</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;

            case 'pdf':
                // Sederhana: konversi HTML ke PDF pakai dompdf atau TCPDF
                echo "Export PDF belum diimplementasikan.";
                break;
        }
    }

    public function exportHarian($data, $kelas, $wali, $tanggal, $format)
    {
        $filename = "rekap_harian_{$kelas}_" . str_replace('-', '_', $tanggal);

        $mapelList = !empty($data) ? array_keys(reset($data)['mapel']) : [];
        $headers = ['Nama Siswa', 'Kelas'];
        foreach ($mapelList as $m) {
            $headers[] = $m;
        }
        $headers[] = 'Absen Final';

        $rows = [];
        foreach ($data as $siswa) {
            $row = [
                $siswa['nama_siswa'],
                $siswa['nama_kelas']
            ];
            foreach ($mapelList as $m) {
                $row[] = $siswa['mapel'][$m] ?? '-';
            }
            $row[] = strtoupper($siswa['final']);
            $rows[] = $row;
        }

        switch ($format) {
            case 'csv':
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=$filename.csv");
                $f = fopen('php://output', 'w');
                fputcsv($f, $headers);
                foreach ($rows as $r) {
                    fputcsv($f, $r);
                }
                fclose($f);
                break;

            case 'xls':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$filename.xls");
                echo "<table border='1'><tr>";
                foreach ($headers as $head) {
                    echo "<th>$head</th>";
                }
                echo "</tr>";
                foreach ($rows as $r) {
                    echo "<tr>";
                    foreach ($r as $cell) {
                        echo "<td>$cell</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;

            case 'pdf':
                echo "Export PDF belum diimplementasikan.";
                break;
        }
    }

    public function exportDetailMapel($data, $info, $bulan, $tahun, $format)
    {
        $filename = "absensi_mapel_{$info['nama_kelas']}_{$info['nama_mapel']}";

        $headers = ['No', 'NIS', 'Nama Siswa'];
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        for ($d = 1; $d <= $jumlahHari; $d++) {
            $headers[] = $d;
        }

        $rows = [];
        $no = 1;
        foreach ($data as $siswa) {
            if (!empty(array_filter($siswa['kehadiran']))) {
                $row = [
                    $no++,
                    $siswa['nis'],
                    $siswa['nama_siswa']
                ];
                for ($d = 1; $d <= $jumlahHari; $d++) {
                    $row[] = $siswa['kehadiran'][$d] ?? '-';
                }
                $rows[] = $row;
            }
        }

        switch ($format) {
            case 'csv':
                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=$filename.csv");
                $f = fopen('php://output', 'w');
                fputcsv($f, $headers);
                foreach ($rows as $r) {
                    fputcsv($f, $r);
                }
                fclose($f);
                break;

            case 'xls':
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$filename.xls");
                echo "<table border='1'><tr>";
                foreach ($headers as $head) echo "<th>$head</th>";
                echo "</tr>";
                foreach ($rows as $r) {
                    echo "<tr>";
                    foreach ($r as $cell) echo "<td>$cell</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;

            case 'pdf':
                echo "Fitur PDF belum diimplementasikan.";
                break;
        }
    }
}
