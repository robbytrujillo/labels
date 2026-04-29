<?php
session_start();
include '../config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$data = $conn->query("SELECT * FROM users WHERE username='$username'");
$user = $data->fetch_assoc();

if($user && password_verify($password, $user['password'])){
    $_SESSION['login'] = true;
    header("Location: ../dashboard.php");
}else{
    echo "Login gagal!";
}