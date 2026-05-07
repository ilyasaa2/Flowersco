<?php
include 'config.php';

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];

    // Hash password demi keamanan
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Cek apakah email ada di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) {
        // Update password baru
        $update = mysqli_query($conn, "UPDATE users SET password = '$hashed_password' WHERE email = '$email'");

        if ($update) {
            echo "<script>
                    alert('Password berhasil diperbarui! Silakan login kembali.');
                    window.location.href = 'Login.php';
                  </script>";
        } else {
            echo "Gagal mengupdate database: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
                alert('Terjadi kesalahan: Email tidak ditemukan.');
                window.location.href = 'forgot-password.php';
              </script>";
    }
}
?>