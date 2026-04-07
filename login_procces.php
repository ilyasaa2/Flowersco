<?php
session_start();
include 'config.php'; // Pastikan kamu sudah membuat config.php sebelumnya

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Cari user berdasarkan email
    $query  = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Cek apakah password benar
        if (password_verify($password, $user['password'])) {
            // Set session untuk menandai user sudah login
            $_SESSION['login']    = true;
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: Homepage.php"); // Alihkan ke homepage setelah sukses
            exit;
        }
    }

    // Jika gagal, kembali ke login dengan pesan error
    echo "<script>
            alert('Email atau Password salah!');
            window.location.href = 'Login.php';
          </script>";
}
?>