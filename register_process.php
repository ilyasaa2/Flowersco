<?php
include 'config.php';

if (isset($_POST['register'])) {
    // mengambil data dan mengamankannya dari SQL injection
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    // mengenkripsi password di database
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // cek apakah email sudah terdaftar sebelumnya
    $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>
                alert('Email sudah terdaftar! Gunakan email lain.');
                window.location.href = 'Register.php';
              </script>";
    } else {
        // memasukkan data user baru
        $query = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Registrasi Berhasil! Silakan Login.');
                    window.location.href = 'Login.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>