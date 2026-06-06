<?php
include 'config.php';

// Pastikan hanya admin yang bisa memproses
if (!isset($_SESSION['login']) || $_SESSION['email'] !== 'flowerscomgl@gmail.com') {
    header("Location: Login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id = $_POST['id']; // Jika ada ID, berarti sedang EDIT. Jika kosong, berarti TAMBAH.
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    // Pastikan harga yang masuk ke database adalah angka murni tanpa titik/koma
    $harga = (int)preg_replace('/[^0-9]/', '', $_POST['harga']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $stok = (int)$_POST['stok'];
    
    // Logika Upload Gambar
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    if ($id == "") { 
        // --- LOGIKA TAMBAH PRODUK BARU ---
        move_uploaded_file($tmp_name, 'img/' . $nama_gambar);
        $query = "INSERT INTO produk (nama_produk, kategori, harga, gambar, stok) VALUES ('$nama', '$kategori', '$harga', '$nama_gambar', '$stok')";
    } else {
        // --- LOGIKA EDIT PRODUK ---
        if ($nama_gambar != "") {
            // Jika admin mengunggah gambar baru
            move_uploaded_file($tmp_name, 'img/' . $nama_gambar);
            $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', gambar='$nama_gambar', stok='$stok' WHERE id='$id'";
        } else {
            // Jika admin tidak mengganti gambar (pakai gambar lama)
            $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok' WHERE id='$id'";
        }
    }

    if (mysqli_query($conn, $query)) {
        header("Location: admin_dashboard.php?status=sukses#daftar-produk");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>