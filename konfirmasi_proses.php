<?php
include 'config.php';
session_start();

// Cek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_bayar = $_GET['id'];

    // Update status di tabel pembayaran berdasarkan gambar database Anda
    // Kita ubah status dari 'pending' menjadi 'success'
    $query = "UPDATE pembayaran SET status = 'berhasil' WHERE id_pembayaran = '$id_bayar'";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke dashboard dengan pesan sukses
        echo "<script>
                alert('Pembayaran berhasil dikonfirmasi!');
                window.location.href = 'admin_dashboard.php';
              </script>";
    } else {
        // Jika gagal
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika diakses tanpa ID, lempar kembali ke dashboard
    header("Location: admin_dashboard.php");
}
?>