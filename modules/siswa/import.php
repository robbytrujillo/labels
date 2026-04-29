<?php
include '../../config/database.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['import'])){

    // ================= VALIDASI FILE =================
    if(!isset($_FILES['file']) || $_FILES['file']['error'] != 0){
        echo "<script>alert('File tidak valid!');history.back();</script>";
        exit;
    }

    $file = $_FILES['file']['tmp_name'];
    $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if(!in_array($ext, ['xlsx','xls'])){
        echo "<script>alert('Format harus Excel (.xlsx / .xls)!');history.back();</script>";
        exit;
    }

    try{
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        $berhasil = 0;
        $duplikat = 0;
        $gagal    = 0;

        foreach($sheet as $i => $row){

            if($i == 0) continue; // skip header

            $nisn  = trim($row[0]);
            $nama  = trim($row[1]);
            $kelas = trim($row[2]);
            $absen = trim($row[3]);

            // ================= VALIDASI KOSONG =================
            if($nisn == '' || $nama == '' || $kelas == '' || $absen == ''){
                $gagal++;
                continue;
            }

            // ================= VALIDASI ANGKA =================
            if(!is_numeric($nisn) || !is_numeric($absen)){
                $gagal++;
                continue;
            }

            // ================= CEK DUPLIKAT NISN =================
            $cek = $conn->query("SELECT id FROM siswa WHERE nisn='$nisn'");
            if($cek->num_rows > 0){
                $duplikat++;
                continue;
            }

            // ================= INSERT =================
            $nisn  = $conn->real_escape_string($nisn);
            $nama  = $conn->real_escape_string($nama);
            $kelas = $conn->real_escape_string($kelas);
            $absen = $conn->real_escape_string($absen);

            $insert = $conn->query("INSERT INTO siswa (nisn,nama,kelas,absen)
                                   VALUES ('$nisn','$nama','$kelas','$absen')");

            if($insert){
                $berhasil++;
            } else {
                $gagal++;
            }
        }

        // ================= REDIRECT DENGAN INFO =================
        header("Location: ../../dashboard.php?import=success&ok=$berhasil&dup=$duplikat&fail=$gagal");

    } catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
}