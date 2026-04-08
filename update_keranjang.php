<?php
include 'config.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
$user_id = $_SESSION['user_id'];

// Sanitasi input
$id = mysqli_real_escape_string($conn, $id);

if ($action == 'increase') {
    // Tambah jumlah menggunakan id_keranjang
    mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_keranjang = '$id' AND user_id = '$user_id'");
} 
elseif ($action == 'decrease') {
    // Kurangi jumlah, minimal 1
    mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah - 1 WHERE id_keranjang = '$id' AND user_id = '$user_id' AND jumlah > 1");
} 
elseif ($action == 'delete') {
    // Hapus satu produk berdasarkan id_keranjang
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id' AND user_id = '$user_id'");
} 
elseif ($action == 'clear') {
    // Hapus semua isi keranjang user
    mysqli_query($conn, "DELETE FROM keranjang WHERE user_id = '$user_id'");
}

// Redirect balik ke keranjang
header("Location: keranjang.php");
exit;
?>