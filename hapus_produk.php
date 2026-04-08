<?php
include 'config.php';
session_start();

// Testing: Jika terlempar ke login terus, coba matikan dulu proteksi email untuk tes
if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Hapus data di database
    $query = "DELETE FROM produk WHERE id = '$id'";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        // Redirect kembali ke dashboard setelah berhasil
        header("Location: admin_dashboard.php?status=terhapus");
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    header("Location: admin_dashboard.php");
}
?>