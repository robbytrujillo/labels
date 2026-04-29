<?php
include 'config/database.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['import'])){
    $file = $_FILES['file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    foreach($sheet as $key => $row){
        if($key == 0) continue; // skip header

        $nama = $row[0];
        $kelas = $row[1];
        $absen = $row[2];

        $conn->query("INSERT INTO siswa (nama,kelas,absen)
                      VALUES ('$nama','$kelas','$absen')");
    }

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Import Excel</title>
</head>

<body class="container mt-5">

    <h3>Import Excel</h3>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button name="import" class="btn btn-success">Import</button>
    </form>

    <p>Format Excel:</p>
    <ul>
        <li>Kolom A: Nama</li>
        <li>Kolom B: Kelas</li>
        <li>Kolom C: Absen</li>
    </ul>

</body>

</html>