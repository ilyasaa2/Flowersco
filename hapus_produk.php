<?php
include 'config.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM produk WHERE id = '$id'");
header("Location: admin_dashboard.php");
?>