<?php
// api_get_produk.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Mengizinkan Flutter mengakses file ini

// 1. KONEKSI DATABASE
// Sesuaikan dengan file koneksi milik websitemu sendiri.
// Jika kamu punya file 'koneksi.php', kamu bisa langsung pakai: include "koneksi.php";
$koneksi = mysqli_connect("localhost", "root", "", "flowers_db");

if (!$koneksi) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit();
}

// 2. QUERY AMBIL DATA
// Sesuaikan 'produk' dengan nama tabel di databasemu
$query = mysqli_query($koneksi, "SELECT id, nama_produk, harga FROM produk");

$banyak_produk = [];
while ($row = mysqli_fetch_assoc($query)) {
    $banyak_produk[] = $row;
}

// 3. MENGUBAH MENJADI JSON
// Data ini yang nantinya akan dibaca oleh Flutter
echo json_encode($banyak_produk);
?>