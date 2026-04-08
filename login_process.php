<?php
include 'config.php'; 
session_start(); 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
        echo "<script>alert('Format email tidak valid!'); window.location.href='Login.php';</script>";
        exit;
    }

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        // memverifikasi password yang sudah di hash saat register
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['fullname'] = $row['fullname']; // Menyimpan nama user ke sesi
            
            header("Location: Homepage.html"); 
            exit;
        } else {
            header("Location: Login.php?error=password");
            exit;
        }
    } else {
        header("Location: Login.php?error=email");
        exit;
    }
}
?>