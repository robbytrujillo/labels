<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

/*
|--------------------------------------------------------------------------
| KELAS BUNGUR
| XI-2, XI-3, XI-4
|--------------------------------------------------------------------------
*/
$data = $conn->query("
    SELECT * FROM siswa 
    WHERE kelas IN ('XI-2', 'XI-3', 'XI-4')
    ORDER BY 
        FIELD(kelas, 'XI-2', 'XI-3', 'XI-4'),
        absen ASC
");

/* ===== LOGO ===== */
$logoPath = '../../assets/logo-sma.png';
$logoBase64 = '';

if (file_exists($logoPath)) {
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $img = file_get_contents($logoPath);
    $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
}

/* ===== HTML ===== */
$html = '
<style>
body {
    font-family: Arial, sans-serif;
}

@page {
    margin: 20px;
}

.page-break {
    page-break-after: always;
}

.title {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.subtitle {
    text-align: center;
    font-size: 12px;
    margin-bottom: 15px;
    color: #555;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 10px 12px;
    table-layout: fixed;
}

td {
    width: 50%;
    vertical-align: top;
}

.label {
    border: 1px solid #ccc;
    border-radius: 12px;
    height: 100px;
    background: #e8f5e9;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
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
    padding-right: 85px;
    padding-left: 15px;
}

.qr-container {
    position: absolute;
    right: 35px;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
}

.qr-container img {
    width: 60px;
    height: 60px;
    display: block;
}

.logo {
    width: 22px;
    margin: 0 auto 3px auto;
    display: block;
}

.nisn {
    font-size: 9px;
    color: #666;
    margin: 0;
}

.nama {
    font-size: 13px;
    font-weight: bold;
    margin: 2px 0;
}

.kelas {
    font-size: 11px;
}

.absen {
    font-size: 11px;
    font-weight: bold;
}
</style>
';

$counter = 0;
$batch = 1;

$html .= "
<div class='title'>LABEL SISWA KELAS BUNGUR</div>
<div class='subtitle'>XI-2 • XI-3 • XI-4 | Batch $batch</div>
<table>
";

while ($d = $data->fetch_assoc()) {

    /* ===== SETIAP 10 SISWA HALAMAN BARU ===== */
    if ($counter > 0 && $counter % 10 == 0) {

        if ($counter % 2 == 1) {
            $html .= '<td></td></tr>';
        }

        $batch++;

        $html .= "
        </table>
        <div class='page-break'></div>
        <div class='title'>LABEL SISWA KELAS BUNGUR</div>
        <div class='subtitle'>XI-2 • XI-3 • XI-4 | Batch $batch</div>
        <table>
        ";
    }

    if ($counter % 2 == 0) {
        $html .= '<tr>';
    }

    /* ===== QR ===== */
    $qr = Builder::create()
        ->data("NISN: {$d['nisn']} | Nama: {$d['nama']} | Kelas: {$d['kelas']} | Absen: {$d['absen']}")
        ->size(80)
        ->margin(0)
        ->build();

    $qrImg = $qr->getDataUri();

    $html .= "
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
                <img src='$qrImg'>
            </div>
        </div>
    </td>
    ";

    if ($counter % 2 == 1) {
        $html .= '</tr>';
    }

    $counter++;
}

/* ===== JIKA GANJIL ===== */
if ($counter % 2 == 1) {
    $html .= '<td></td></tr>';
}

$html .= '</table>';

/* ===== PDF ===== */
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("label-kelas-bungur.pdf", ["Attachment" => false]);
?>