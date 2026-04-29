<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

// ambil data
$data = $conn->query("SELECT * FROM siswa ORDER BY kelas, absen ASC");

// ===== FIX LOGO (BASE64 WAJIB UNTUK DOMPDF) =====
$logoPath = '../../assets/logo-sma.png';
$logoBase64 = '';

if(file_exists($logoPath)){
    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
}

$html = '
<style>
body {
    font-family: Arial, sans-serif;
}

/* GRID 2 KOLOM */
.label {
    width: 48%;
    height: 95px;
    border: 1px solid #333;
    border-radius: 10px;
    padding: 8px;
    margin-bottom: 10px;
    display: inline-block;
    vertical-align: top;
    box-sizing: border-box;
}

/* BIAR KE KANAN */
.label:nth-child(odd){
    margin-right: 4%;
}

/* FLEX DALAM LABEL */
.row {
    display: table;
    width: 100%;
}

.col-left {
    display: table-cell;
    width: 70%;
    vertical-align: middle;
}

.col-right {
    display: table-cell;
    width: 30%;
    text-align: right;
    vertical-align: middle;
}

/* TEXT */
.nama {
    font-size: 14px;
    font-weight: bold;
}

.kelas {
    font-size: 12px;
    color: #555;
}

.absen {
    font-size: 12px;
}

/* QR */
.qr img {
    width: 55px;
}

/* LOGO */
.logo {
    width: 25px;
    margin-bottom: 3px;
}
</style>
';

while($d = $data->fetch_assoc()){

    // warna per kelas
    $warna = "#f8f9fa";
    if(strpos($d['kelas'], 'X ') !== false) $warna = "#e3f2fd";
    if(strpos($d['kelas'], 'XI') !== false) $warna = "#e8f5e9";
    if(strpos($d['kelas'], 'XII') !== false) $warna = "#fff3cd";

    // QR
    $qr = Builder::create()
        ->data("Nama: ".$d['nama']." | ".$d['kelas']." | ".$d['absen'])
        ->size(80)
        ->margin(0)
        ->build();

    $qrImg = $qr->getDataUri();

    $html .= "
    <div class='label' style='background:$warna'>

        <div class='row'>

            <div class='col-left'>
                ".($logoBase64 ? "<img src='$logoBase64' class='logo'><br>" : "")."
                <div class='nama'>".strtoupper($d['nama'])."</div>
                <div class='kelas'>".$d['kelas']."</div>
                <div class='absen'>No: ".$d['absen']."</div>
            </div>

            <div class='col-right qr'>
                <img src='$qrImg'>
            </div>

        </div>

    </div>
    ";
}

$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("label-laci.pdf", ["Attachment" => false]);