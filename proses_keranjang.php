<?php
include 'config.php';
session_start();

if (!isset($_SESSION['login'])) {
    http_response_code(401);
    exit;
}

if (isset($_POST['tambah_keranjang'])) {
    $user_id = $_SESSION['user_id'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (int)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];
    $gambar = basename($_POST['gambar']); 

    $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    } else {
        $query = "INSERT INTO keranjang (user_id, nama_produk, harga, jumlah, gambar) VALUES ('$user_id', '$nama_produk', '$harga', '$jumlah', '$gambar')";
        mysqli_query($conn, $query);
    }
    echo "Berhasil";
}
?>