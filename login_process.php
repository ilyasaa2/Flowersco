<?php
include 'config.php'; // Menghubungkan ke database
session_start(); // Memulai sesi untuk menyimpan data login

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        // Memverifikasi password yang sudah di-hash saat register
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['fullname'] = $row['fullname']; // Menyimpan nama user ke sesi
            
            header("Location: Homepage.html"); 
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location.href='Login.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar!'); window.location.href='Login.php';</script>";
    }
}
?>