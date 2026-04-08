<?php
include 'config.php';
session_start();

// Memastikan user sudah login
if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    die("<script>alert('Silakan login terlebih dahulu!'); window.location='Login.php';</script>");
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari session yang sudah sinkron
$metode_pembayaran = $_POST['metode'] ?? '';

if (empty($metode_pembayaran)) {
    die("<script>alert('Pilih metode pembayaran!'); window.history.back();</script>");
}

// 2. Ambil data keranjang user untuk menghitung total
$keranjang_query = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'");

// Cek jika keranjang kosong sebelum diproses
if (mysqli_num_rows($keranjang_query) == 0) {
    die("<script>alert('Keranjang Anda kosong!'); window.location='Katalog.php';</script>");
}

$total_bayar = 0;
$biaya_admin = 2500;

while($item = mysqli_fetch_assoc($keranjang_query)) {
    $harga_produk = (int)$item['harga'];
    $jumlah       = (int)$item['jumlah'];
    $total_bayar += $harga_produk * $jumlah;
}

$total_bayar += $biaya_admin;

// 3. Simpan data ke tabel pembayaran
$query = "INSERT INTO pembayaran 
          (user_id, metode_pembayaran, jumlah_bayar, status) 
          VALUES 
          ('$user_id', '$metode_pembayaran', $total_bayar, 'pending')";

if (mysqli_query($conn, $query)) {
    // 4. BARIS TAMBAHAN: Kosongkan keranjang setelah data pembayaran aman tersimpan
    mysqli_query($conn, "DELETE FROM keranjang WHERE user_id = '$user_id'");

    echo "<script>
            alert('Transaksi sedang diproses!');
            window.location='Katalog.php';
          </script>";
} else {
    // Jika query pembayaran gagal, keranjang tidak akan dihapus
    die("Gagal menyimpan pembayaran: " . mysqli_error($conn));
}
?>