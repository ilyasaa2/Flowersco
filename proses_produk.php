<?php
include 'config.php';
session_start();

// Pastikan hanya admin yang bisa memproses
if (!isset($_SESSION['login']) || $_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: Login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id = $_POST['id']; // Jika ada ID, berarti sedang EDIT. Jika kosong, berarti TAMBAH.
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = $_POST['harga'];
    
    // Logika Upload Gambar
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    if ($id == "") { 
        // --- LOGIKA TAMBAH PRODUK BARU ---
        move_uploaded_file($tmp_name, 'img/' . $nama_gambar);
        $query = "INSERT INTO produk (nama_produk, harga, gambar) VALUES ('$nama', '$harga', '$nama_gambar')";
    } else {
        // --- LOGIKA EDIT PRODUK ---
        if ($nama_gambar != "") {
            // Jika admin mengunggah gambar baru
            move_uploaded_file($tmp_name, 'img/' . $nama_gambar);
            $query = "UPDATE produk SET nama_produk='$nama', harga='$harga', gambar='$nama_gambar' WHERE id='$id'";
        } else {
            // Jika admin tidak mengganti gambar (pakai gambar lama)
            $query = "UPDATE produk SET nama_produk='$nama', harga='$harga' WHERE id='$id'";
        }
    }

    if (mysqli_query($conn, $query)) {
        header("Location: Admin.php?status=sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>