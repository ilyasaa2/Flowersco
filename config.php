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

// Hitung total jumlah produk di keranjang untuk ditampilkan pada badge icon
$total_keranjang = 0;
if (isset($_SESSION['login'])) {
    $uid_session = $_SESSION['user_id'];
    $q_keranjang = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keranjang WHERE user_id = '$uid_session'");
    $d_keranjang = mysqli_fetch_assoc($q_keranjang);
    $total_keranjang = (int)($d_keranjang['total'] ?? 0);
}
?>