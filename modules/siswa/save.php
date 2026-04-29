<?php
include '../../config/database.php';

$id    = isset($_POST['id']) ? $_POST['id'] : '';
$nisn  = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';
$nama  = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$kelas = isset($_POST['kelas']) ? trim($_POST['kelas']) : '';
$absen = isset($_POST['absen']) ? trim($_POST['absen']) : '';

// ================= VALIDASI =================
if($nisn == '' || $nama == '' || $kelas == '' || $absen == ''){
    echo "<script>alert('Semua field wajib diisi!');history.back();</script>";
    exit;
}

// validasi angka
if(!is_numeric($nisn)){
    echo "<script>alert('NISN harus berupa angka!');history.back();</script>";
    exit;
}

if(!is_numeric($absen)){
    echo "<script>alert('Absen harus berupa angka!');history.back();</script>";
    exit;
}

// escape
$nisn  = $conn->real_escape_string($nisn);
$nama  = $conn->real_escape_string($nama);
$kelas = $conn->real_escape_string($kelas);
$absen = $conn->real_escape_string($absen);

// ================= CEK DUPLIKAT NISN =================
if($id == ''){
    // create
    $cek = $conn->query("SELECT id FROM siswa WHERE nisn='$nisn'");
} else {
    // update (exclude id sendiri)
    $cek = $conn->query("SELECT id FROM siswa WHERE nisn='$nisn' AND id != '$id'");
}

if($cek->num_rows > 0){
    echo "<script>alert('NISN sudah digunakan!');history.back();</script>";
    exit;
}

// ================= QUERY =================
if($id == ''){
    // CREATE
    $query = "INSERT INTO siswa (nisn, nama, kelas, absen) 
              VALUES ('$nisn', '$nama', '$kelas', '$absen')";
} else {
    // UPDATE
    $query = "UPDATE siswa SET 
                nisn='$nisn',
                nama='$nama',
                kelas='$kelas',
                absen='$absen'
              WHERE id='$id'";
}

// ================= EKSEKUSI =================
if($conn->query($query)){
    header("Location: ../../dashboard.php?success=1");
} else {
    echo "<script>alert('Gagal menyimpan data!');history.back();</script>";
}