<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Label</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
    .label-box {
        width: 300px;
        height: 80px;
        border: 1px solid #000;
        border-radius: 8px;
        padding: 8px;
        margin: 5px;
        float: left;
        font-size: 14px;
    }

    .nama {
        font-weight: bold;
        font-size: 16px;
    }
    </style>

</head>

<body onload="window.print()">

    <?php
$data = $conn->query("SELECT * FROM siswa ORDER BY kelas, absen ASC");

while($d = $data->fetch_assoc()){
?>

    <div class="label-box">
        <div class="nama"><?= strtoupper($d['nama']) ?></div>
        <div>Kelas: <?= $d['kelas'] ?></div>
        <div>Absen: <?= $d['absen'] ?></div>
    </div>

    <?php } ?>

</body>

</html>