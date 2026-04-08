<?php
include 'config.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Hapus hanya milik user yang sedang login
    mysqli_query($conn, "DELETE FROM keranjang WHERE user_id = '$user_id'");
}

header("Location: Keranjang.php");
exit;
?>