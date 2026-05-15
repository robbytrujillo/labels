<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

/*
|--------------------------------------------------------------------------
| PDF LOKER SISWA
| URUTAN:
| X-2 → halaman baru → X-4
| 1 HALAMAN = 12 SISWA
| 1 LACI = 4 SISWA
| 3 LACI / HALAMAN
|--------------------------------------------------------------------------
*/

$kelasList = ['X-2', 'X-4'];

/* ===== LOGO ===== */
$logoPath = '../../assets/logo-sma.png';
$logoBase64 = '';

if (file_exists($logoPath)) {
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $img = file_get_contents($logoPath);
    $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
}

/* ===== STYLE PDF ===== */
$html = '
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    font-size: 11px;
}

@page {
    margin: 10px;
}

.page-break {
    page-break-after: always;
}

.title {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 2px;
}

.subtitle {
    text-align: center;
    font-size: 11px;
    margin-bottom: 8px;
    color: #555;
}

.drawer-title {
    font-size: 11px;
    font-weight: bold;
    margin: 5px 0 3px 0;
    padding: 4px 8px;
    background: #1e293b;
    color: white;
    border-radius: 5px;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 3px;
    table-layout: fixed;
}

td {
    width: 100%;
    vertical-align: top;
}

.label {
    border: 1px solid #ccc;
    border-radius: 8px;
    height: 60px;
    background: #f8fafc;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
    padding: 2px 0;
}

.text-container {
    width: 100%;
    height: 100%;
    display: table;
}

.text-inner {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    padding-right: 65px;
    padding-left: 8px;
}

.qr-container {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 34px;
}

.qr-container img {
    width: 34px;
    height: 34px;
}

.logo {
    width: 12px;
    margin: 0 auto 1px auto;
    display: block;
}

.nisn {
    font-size: 7px;
    color: #666;
    margin: 0;
    line-height: 1;
}

.nama {
    font-size: 9px;
    font-weight: bold;
    margin: 1px 0;
    line-height: 1;
}

.kelas {
    font-size: 8px;
    margin: 1px 0;
    line-height: 1;
}

.absen {
    font-size: 8px;
    font-weight: bold;
    margin-top: 1px;
    line-height: 1;
}
</style>
';

/* ===== LOOP PER KELAS ===== */
foreach ($kelasList as $kelas) {

    $data = $conn->query("
        SELECT * FROM siswa
        WHERE kelas = '$kelas'
        ORDER BY absen ASC
    ");

    if ($data->num_rows == 0) continue;

    $html .= "
    <div class='title'>LABEL LOKER SISWA</div><div class='subtitle'>Kelas $kelas</div>
    ";

    $pageCounter = 0;
    $drawer = 1;

    while ($d = $data->fetch_assoc()) {

        /* ===== HALAMAN BARU SETELAH 12 SISWA ===== */
        if ($pageCounter == 12) {
            $html .= "</table>";
            $html .= "<div class='page-break'></div>";

            $html .= "
            <div class='title'>LABEL LOKER SISWA</div><div class='subtitle'>Kelas $kelas</div>
            
            ";

            $pageCounter = 0;
            $drawer = 1;
        }

        /* ===== AWAL LACI SETIAP 4 SISWA ===== */
        if ($pageCounter % 4 == 0) {

            if ($pageCounter > 0) {
                $html .= "</table>";
            }

            $html .= "
            <div class='drawer-title'>Laci $drawer</div>
            <table>
            ";

            $drawer++;
        }

        /* ===== QR CODE ===== */
        $qr = Builder::create()
            ->data("NISN: {$d['nisn']} | Nama: {$d['nama']} | Kelas: {$d['kelas']} | Absen: {$d['absen']}")
            ->size(55)
            ->margin(0)
            ->build();

        $qrImg = $qr->getDataUri();

        $html .= "
        <tr>
            <td>
                <div class='label'>
                    <div class='text-container'>
                        <div class='text-inner'>
                            " . ($logoBase64 ? "<img src='$logoBase64' class='logo'>" : "") . "
                            <div class='nisn'>NISN: {$d['nisn']}</div>
                            <div class='nama'>" . strtoupper($d['nama']) . "</div>
                            <div class='kelas'>{$d['kelas']}</div>
                            <div class='absen'>No. {$d['absen']}</div>
                        </div>
                    </div>

                    <div class='qr-container'>
                        <img src='{$qrImg}'>
                    </div>
                </div>
            </td>
        </tr>
        ";

        $pageCounter++;
    }

    $html .= "</table>";

    /* ===== HALAMAN BARU SETELAH KELAS SELESAI ===== */
    $html .= "<div class='page-break'></div>";
}

/* ===== GENERATE PDF ===== */
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("label-loker-siswa.pdf", ["Attachment" => false]);
?>