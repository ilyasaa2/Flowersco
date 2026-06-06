<?php
include 'config.php';

if (!isset($_SESSION['login'])) {
    if (isset($_POST['ajax'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    http_response_code(401);
    exit;
}

if (isset($_POST['tambah_keranjang'])) {
    $user_id = $_SESSION['user_id'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    
    // Membersihkan harga dari karakter selain angka sebelum dikonversi ke integer
    $harga = (int)preg_replace('/[^0-9]/', '', $_POST['harga']);
    $jumlah = (int)$_POST['jumlah'];
    $gambar = basename($_POST['gambar']); 

    // 1. Ambil stok asli dari database produk
    $q_stok = mysqli_query($conn, "SELECT stok FROM produk WHERE nama_produk = '$nama_produk'");
    $d_stok = mysqli_fetch_assoc($q_stok);
    $stok_tersedia = $d_stok['stok'] ?? 0;

    // 2. Hitung berapa yang sudah ada di keranjang user
    $cek_item = mysqli_query($conn, "SELECT jumlah FROM keranjang WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    $row_item = mysqli_fetch_assoc($cek_item);
    $jumlah_lama = $row_item ? (int)$row_item['jumlah'] : 0;

    // 3. Validasi: stok tidak boleh dilampaui
    if (($jumlah_lama + $jumlah) > $stok_tersedia) {
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => false, 'message' => "Maaf, stok terbatas. Sisa stok: $stok_tersedia"]);
            exit;
        }
        echo "<script>alert('Stok tidak mencukupi!'); window.history.back();</script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE user_id = '$user_id' AND nama_produk = '$nama_produk'");
    } else {
        $query = "INSERT INTO keranjang (user_id, nama_produk, harga, jumlah, gambar) VALUES ('$user_id', '$nama_produk', '$harga', '$jumlah', '$gambar')";
        mysqli_query($conn, $query);
    }

    if (isset($_POST['ajax'])) {
        $q_total = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keranjang WHERE user_id = '$user_id'");
        $d_total = mysqli_fetch_assoc($q_total);
        echo json_encode(['success' => true, 'total' => (int)$d_total['total']]);
        exit;
    }

    // Mengalihkan ke halaman keranjang setelah berhasil
    header("Location: Keranjang.php");
    exit;
}
?>