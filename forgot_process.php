<?php
include 'config.php';

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Enkripsi password baru
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Cek apakah email ada di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        // Update password di database
        $update = mysqli_query($conn, "UPDATE users SET password = '$new_password' WHERE email = '$email'");
        
        if ($update) {
            echo "<script>
                    alert('Password berhasil diperbarui! Silakan login kembali.');
                    window.location.href = 'Login.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
                alert('Email tidak ditemukan dalam sistem kami.');
                window.location.href = 'Forgot-password.php';
              </script>";
    }
}
?>