<?php include 'config/database.php'; ?>

<?php
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $absen = $_POST['absen'];

    $conn->query("INSERT INTO siswa (nama, kelas, absen)
                  VALUES ('$nama','$kelas','$absen')");
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h3>Tambah Data</h3>

    <form method="POST">
        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Siswa" required>
        <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas" required>
        <input type="number" name="absen" class="form-control mb-2" placeholder="No Absen" required>

        <button name="simpan" class="btn btn-primary">Simpan</button>
    </form>

</body>

</html>