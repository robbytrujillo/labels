<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

$data = $conn->query("SELECT * FROM siswa ORDER BY kelas, absen ASC");

// ===== LOGO =====
$logoPath = '../../assets/logo-sma.png';
$logoBase64 = '';

if(file_exists($logoPath)){
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $img = file_get_contents($logoPath);
    $logoBase64 = 'data:image/'.$type.';base64,'.base64_encode($img);
}

// ===== HTML =====
$html = '
<style>
body { font-family: Arial, sans-serif; }
@page { margin: 20px; }

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 10px 12px;
    table-layout: fixed;
}

td { width: 50%; vertical-align: top; }

/* LABEL */
.label {
    border: 1px solid #ccc;
    border-radius: 12px;
    height: 100px; 
    background: #fff;
    position: relative; 
    overflow: hidden;
    box-sizing: border-box;
}

/* KONTEN TEKS */
.text-container {
    width: 100%;
    height: 100%;
    display: table;
}

.text-inner {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    /* TAMBAHKAN PADDING INI: Agar teks tidak menabrak QR yang digeser ke kiri */
    padding-right: 85px; 
    padding-left: 15px;
}

/* QR CODE - DIGESER LEBIH KE KIRI */
.qr-container {
    position: absolute;
    /* UBAH NILAI INI: Semakin besar angkanya, semakin ke kiri */
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

/* TYPOGRAPHY */
.logo { width: 22px; margin: 0 auto 3px auto; display: block; }
.nisn { font-size: 9px; color: #666; margin: 0; line-height: 1; }
.nama { font-size: 13px; font-weight: bold; margin: 2px 0; line-height: 1.1; }
.kelas { font-size: 11px; margin: 1px 0; }
.absen { font-size: 11px; font-weight: bold; margin-top: 2px; }
</style>

<div class="wrapper">
<table>
';

$no = 0;

while($d = $data->fetch_assoc()){

    if($no % 2 == 0){
        $html .= '<tr>';
    }

    // warna per kelas
    $warna = "#ffffff";
    if(strpos($d['kelas'], 'X ') !== false) $warna = "#e3f2fd";
    if(strpos($d['kelas'], 'XI') !== false) $warna = "#e8f5e9";
    if(strpos($d['kelas'], 'XII') !== false) $warna = "#fff3cd";

    // QR
    $qr = Builder::create()
        ->data("NISN: ".$d['nisn']." | Nama: ".$d['nama']." | Kelas: ".$d['kelas']." | Absen: ".$d['absen'])
        ->size(80)
        ->margin(0)
        ->build();

    $qrImg = $qr->getDataUri();

    $html .= "
    <td>
        <div class='label' style='background:$warna'>
            
            <div class='text-container'>
                <div class='text-inner'>
                    ".($logoBase64 ? "<img src='$logoBase64' class='logo'>" : "")."
                    <div class='nisn'>NISN: ".$d['nisn']."</div>
                    <div class='nama'>".strtoupper($d['nama'])."</div>
                    <div class='kelas'>".$d['kelas']."</div>
                    <div class='absen'>No. ".$d['absen']."</div>
                </div>
            </div>

            <div class='qr-container'>
                <img src='$qrImg'>
            </div>

        </div>
    </td>
    ";

    if($no % 2 == 1){
        $html .= '</tr>';
    }

    $no++;
}

// jika ganjil
if($no % 2 == 1){
    $html .= '<td></td></tr>';
}

$html .= '
</table>
</div>
';

// ===== PDF =====
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("label-siswa.pdf", ["Attachment" => false]);