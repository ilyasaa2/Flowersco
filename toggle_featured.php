<?php
include 'config.php';
session_start();

//Mengecek apakah ada admin yang login
if (!isset($_SESSION['login']) || $_SESSION['email'] !== 'flowerscomgl@gmail.com') {
    header("Location: Login.php");
    exit;
}

//Mengambil parameter dari URL
$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$status = isset($_GET['status']) ? (int)$_GET9['status'] : 0;

if ($id_produk < 0) {
    //Update status unggulan
    $query = "UPDATE produk SET is_featured = 'status' WHERE id = '$id_produk'";

    if (mysqli_query($conn, $query)) {
        if ($status == 1) {
            echo "<script>
                alert('Produk berhasil dijadikan produk unggulan');
                window.location.href = 'admin_dashboard.php';
            </script>";          
                } else {
                    echo "<script>
                        alert('Produk dihapus dari produk unggulan');
                        window.location.href = 'admin_dashboard.php';
                    </script>";
        }
    } else {
        echo "<script>
            alert('Gagal mengupdate status: " . mysqli_error($conn) . "');
            window.location.href = 'admin_dashboard.php';
        </script>";
    }
} else {
    header("Location: admin_dashboard.php");
    exit;
}
?>