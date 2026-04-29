<?php
require '../../vendor/autoload.php';
include '../../config/database.php';

use Dompdf\Dompdf;
use Endroid\QrCode\Builder\Builder;

// ambil data
$data = $conn->query("SELECT * FROM siswa ORDER BY kelas, absen ASC");

// ===== LOGO BASE64 (WAJIB UNTUK DOMPDF) =====
$logoPath = '../../assets/logo-sma.png';
$logoBase64 = '';

if(file_exists($logoPath)){
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $dataLogo = file_get_contents($logoPath);
    $logoBase64 = 'data:image/'.$type.';base64,'.base64_encode($dataLogo);
}

// mulai HTML
$html = '
<style>
body { font-family: Arial, sans-serif; }

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    width: 50%;
    vertical-align: top;
    padding: 6px;
}

/* LABEL BOX */
.label {
    border: 1px solid #444;
    border-radius: 10px;
    padding: 8px;
    height: 90px;
}

/* ISI */
.inner {
    width: 100%;
}

.text {
    width: 70%;
    float: left;
}

.qr {
    width: 30%;
    float: right;
    text-align: right;
}

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

.logo {
    width: 25px;
    margin-bottom: 3px;
}

.qr img {
    width: 55px;
}
</style>

<table>
';

$no = 0;

while($d = $data->fetch_assoc()){

    // buka row tiap 2 data
    if($no % 2 == 0){
        $html .= '<tr>';
    }

    // warna
    $warna = "#f8f9fa";
    if(strpos($d['kelas'], 'XI') !== false) $warna = "#e8f5e9";

    // QR
    $qr = Builder::create()
        ->data($d['nama'].' - '.$d['kelas'].' - '.$d['absen'])
        ->size(80)
        ->margin(0)
        ->build();

    $qrImg = $qr->getDataUri();

    $html .= "
    <td>
        <div class='label' style='background:$warna'>
            <div class='inner'>

                <div class='text'>
                    ".($logoBase64 ? "<img src='$logoBase64' class='logo'><br>" : "")."
                    <div class='nama'>".strtoupper($d['nama'])."</div>
                    <div class='kelas'>".$d['kelas']."</div>
                    <div class='absen'>No: ".$d['absen']."</div>
                </div>

                <div class='qr'>
                    <img src='$qrImg'>
                </div>

            </div>
        </div>
    </td>
    ";

    // tutup row tiap 2 data
    if($no % 2 == 1){
        $html .= '</tr>';
    }

    $no++;
}

// kalau ganjil, tutup row
if($no % 2 == 1){
    $html .= '<td></td></tr>';
}

$html .= '</table>';

// render
$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("label-laci.pdf", ["Attachment" => false]);