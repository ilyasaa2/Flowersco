<?php
include 'config.php';

// Cek jika user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

if (isset($_POST['tambah_keranjang'])) {
    $user_id = $_SESSION['user_id'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (int)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];
    $gambar = mysqli_real_escape_string($conn, $_POST['gambar']);

    // 1. Ambil stok asli dari database produk
    $q_stok = mysqli_query($conn, "SELECT stok FROM produk WHERE nama_produk = '$nama_produk'");
    $d_stok = mysqli_fetch_assoc($q_stok);
    $stok_tersedia = $d_stok['stok'] ?? 0;

    // 2. Hitung berapa yang sudah ada di keranjang user saat ini
    $cek_item = mysqli_query($conn, "SELECT jumlah FROM keranjang WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    $row_item = mysqli_fetch_assoc($cek_item);
    $jumlah_lama = $row_item ? (int)$row_item['jumlah'] : 0;

    // 3. Validasi: stok tidak boleh dilampaui
    if (($jumlah_lama + $jumlah) > $stok_tersedia) {
        echo "<script>
                alert('Maaf, stok tidak mencukupi. Sisa stok: $stok_tersedia');
                window.history.back();
              </script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    
    if (mysqli_num_rows($cek) > 0) {
        // Jika sudah ada, tambah jumlahnya saja
        mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    } else {
        // Jika belum ada, masukkan data baru
        $query = "INSERT INTO keranjang (user_id, nama_produk, harga, jumlah, gambar) 
                  VALUES ('$user_id', '$nama_produk', '$harga', '$jumlah', '$gambar')";
        mysqli_query($conn, $query);
    }

    header("Location: Keranjang.php");
    exit;
}
?>