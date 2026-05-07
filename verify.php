<?php
include 'config.php';
session_start();

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);

    // Cari user berdasarkan email
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        // Set session login (sesuaikan dengan nama session di aplikasi kamu)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['nama'];
        $_SESSION['login'] = true;

        // Redirect ke dashboard atau beranda
        header("Location: reset_password.php");
        exit();
    } else {
        echo "Link tidak valid atau akun tidak ditemukan.";
    }
} else {
    echo "Akses ditolak.";
}
?>