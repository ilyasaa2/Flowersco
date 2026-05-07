<?php
include "config.php";

// Isi data katalog di sini
$katalog = [
    ["nama_produk" => "Pink Rose Bouquet", "kategori" => "anniversary", "harga" => 159000, "gambar" => "PinkRoseBouquet.jpg"],
    ["nama_produk" => "Sunflower Bouquet", "kategori" => "ulangtahun", "harga" => 129000, "gambar" => "SunflowerBouquet.jpg"],
    ["nama_produk" => "Wedding Special Bouquet", "kategori" => "pernikahan", "harga" => 250000, "gambar" => "WeddingBouquet.jpg"],
    ["nama_produk" => "Graduation Flowers", "kategori" => "wisuda", "harga" => 175000, "gambar" => "GraduationBouquet.jpg"]
];

foreach ($katalog as $item) {
    $nama   = $item['nama_produk'];
    $kategori = $item['kategori'];
    $harga  = $item['harga'];
    $gambar = $item['gambar'];

    $query = "INSERT INTO produk (nama_produk, kategori, harga, gambar)
              VALUES ('$nama', '$kategori', '$harga', '$gambar')";
    mysqli_query($koneksi, $query);
}

echo "Data katalog berhasil ditambahkan!";
?>