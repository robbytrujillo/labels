<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

/*
|--------------------------------------------------------------------------
| PDF LABEL BUNGUR
| XI-2 + XI-3 + XI-4 BERURUTAN
| TANPA PEMISAH KELAS
| 10 LABEL PER HALAMAN
|--------------------------------------------------------------------------
*/

// $data = $conn->query("
//     SELECT * FROM siswa 
//     WHERE kelas IN ('XI-2', 'XI-3', 'XI-4', 'X-3')
//     ORDER BY kelas ASC, absen ASC
// ");

$data = $conn->query("
    SELECT * FROM siswa 
    WHERE kelas IN ('XI-2', 'XI-3', 'XI-4', 'X-3')
    ORDER BY 
        FIELD(kelas, 'XI-2', 'XI-3', 'XI-4', 'X-3'),
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

/* ===== STYLE ===== */
$html = '
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

@page {
    margin: 15px;
}

.page-break {
    page-break-after: always;
}

.title {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 4px;
}

.subtitle {
    text-align: center;
    font-size: 11px;
    margin-bottom: 10px;
    color: #555;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 6px;
    table-layout: fixed;
}

td {
    width: 100%;
    vertical-align: top;
}

.label {
    border: 1px solid #ccc;
    border-radius: 12px;
    height: 88px;
    background: #e8f5e9;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
    padding: 4px 0;
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
    padding-top: 4px;
    padding-bottom: 4px;
}

.qr-container {
    position: absolute;
    right: 28px;
    top: 50%;
    transform: translateY(-50%);
    width: 52px;
}

.qr-container img {
    width: 52px;
    height: 52px;
    display: block;
}

.logo {
    width: 18px;
    margin: 0 auto 2px auto;
    display: block;
}

.nisn {
    font-size: 9px;
    color: #666;
    margin: 0;
    line-height: 1.1;
}

.nama {
    font-size: 12px;
    font-weight: bold;
    margin: 2px 0;
    line-height: 1.1;
}

.kelas {
    font-size: 11px;
    margin: 1px 0;
    line-height: 1.1;
}

.absen {
    font-size: 11px;
    font-weight: bold;
    margin-top: 3px;
    line-height: 1.1;
}
</style>
';

$counter = 0;
$batch = 1;
$perPage = 10;

$html .= "

<table>
";

while ($d = $data->fetch_assoc()) {

    /* ===== PAGE BREAK TIAP 10 SISWA ===== */
    if ($counter > 0 && $counter % $perPage == 0) {
        $batch++;

        $html .= "
        </table>
        <div class='page-break'></div>


        <table>
        ";
    }

    /* ===== QR ===== */
    $qr = Builder::create()
        ->data("NISN: {$d['nisn']} | Nama: {$d['nama']} | Kelas: {$d['kelas']} | Absen: {$d['absen']}")
        ->size(80)
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
                    <img src='$qrImg'>
                </div>

            </div>
        </td>
    </tr>
    ";

    $counter++;
}

$html .= '
</table>
';

/* ===== GENERATE PDF ===== */
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("label-kelas-bungur.pdf", ["Attachment" => false]);
?>