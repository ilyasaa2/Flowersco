<?php
include 'config.php';
session_start();

// Cek apakah tombol submit sudah diklik
if (isset($_POST['submit'])) {
    
    // Ambil data dari form dan amankan dari karakter aneh
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    
    // Kelola Upload Gambar
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error_file = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // Cek apakah ada gambar yang diupload
    if ($error_file === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!'); window.location.href='admin_dashboard.php';</script>";
        exit;
    }

    // Ambil ekstensi gambar (jpg, jpeg, png)
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // Cek format file
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Format gambar harus JPG, JPEG, atau PNG!'); window.location.href='admin_dashboard.php';</script>";
        exit;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($ukuran_file > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar! Maksimal 2MB'); window.location.href='admin_dashboard.php';</script>";
        exit;
    }

    // Generate nama gambar baru agar tidak bentrok jika ada nama yang sama
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // Pindahkan file gambar ke folder 'img'
    // PASTIKAN kamu sudah membuat folder bernama 'img' di dalam folder proyekmu!
    if (move_uploaded_file($tmp_name, 'img/' . $namaFileBaru)) {
        
        // Masukkan data ke Database
        // Kolom 'id' tidak perlu diisi karena AUTO_INCREMENT
        $query = "INSERT INTO produk (nama_produk, harga, gambar, stok) 
                  VALUES ('$nama_produk', '$harga', '$namaFileBaru', '$stok')";

        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Produk baru berhasil ditambahkan!');
                    window.location.href = 'admin_dashboard.php';
                  </script>";
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
        
    } else {
        echo "<script>alert('Gagal mengunggah gambar ke server!'); window.location.href='admin_dashboard.php';</script>";
    }

} else {
    // Jika mencoba akses file ini tanpa lewat form, tendang balik ke dashboard
    header("Location: admin_dashboard.php");
    exit;
}
?>