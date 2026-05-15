<?php
include '../../config/database.php';

$id = $_GET['id'];

if($id){
    $conn->query("DELETE FROM siswa WHERE id='$id'");
}

header("Location: ../../dashboard.php?deleted=1");