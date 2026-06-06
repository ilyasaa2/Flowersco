<?php
include 'config.php';

if (!isset($_SESSION['login'])) {
    if (isset($_GET['ajax'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    header("Location: Login.php");
    exit;
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
$user_id = $_SESSION['user_id'];

// Sanitasi input
$id = mysqli_real_escape_string($conn, $id);

if ($action == 'increase') {
    // Cek stok sebelum menambah
    $q_val = mysqli_query($conn, "SELECT k.jumlah, p.stok FROM keranjang k 
                                  JOIN produk p ON k.nama_produk = p.nama_produk 
                                  WHERE k.id_keranjang = '$id' AND k.user_id = '$user_id'");
    $data_val = mysqli_fetch_assoc($q_val);

    if ($data_val && $data_val['jumlah'] < $data_val['stok']) {
        mysqli_query($conn, "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id_keranjang = '$id' AND user_id = '$user_id'");
    } else {
        if (isset($_GET['ajax'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'Jumlah Stok telah mencapai batas maksimum (' . ($data_val['stok'] ?? 0) . ')'
            ]);
            exit;
        }
    }
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

if (isset($_GET['ajax'])) {
    // Ambil data terbaru untuk update UI tanpa refresh
    $q_item = mysqli_query($conn, "SELECT jumlah, harga FROM keranjang WHERE id_keranjang = '$id' AND user_id = '$user_id'");
    $item = mysqli_fetch_assoc($q_item);
    
    $q_totals = mysqli_query($conn, "SELECT SUM(jumlah * harga) as grand_total, SUM(jumlah) as total_qty FROM keranjang WHERE user_id = '$user_id'");
    $totals = mysqli_fetch_assoc($q_totals);

    echo json_encode([
        'success' => true,
        'new_qty' => $item ? (int)$item['jumlah'] : 0,
        'new_subtotal' => $item ? (int)$item['jumlah'] * (int)$item['harga'] : 0,
        'grand_total' => (int)($totals['grand_total'] ?? 0),
        'total_qty' => (int)($totals['total_qty'] ?? 0)
    ]);
    exit;
}

header("Location: Keranjang.php#KeranjangList");
exit;
?>