<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "flowers_db";

$conn = mysqli_connect($host, $user, $pass, $db);


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
    
}
    
//Mencegah suatu akun tertimpa dengan akun yang baru login di page lain
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_name('FLOWERSCO_SESSION');
session_start();

//Set user agent jika belum ada
if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = md5($_SERVER['HTTP_USER_AGENT']);     
}

//Mengecek validitas user agent
if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
    session_destroy();
    header("Location: Login.php");
    exit;
}
?>