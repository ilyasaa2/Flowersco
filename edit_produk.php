<?php
include 'config.php';

// Proteksi halaman: Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['login']) || $_SESSION['email'] !== 'flowerscomgl@gmail.com') {
    header("Location: Login.php");
    exit;
}

// Ambil ID produk dari URL
$id = $_GET['id'] ?? '';
if ($id == '') {
    header("Location: admin_dashboard.php");
    exit;
}

// Ambil data produk lama dari database
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
$p = mysqli_fetch_assoc($query);

if (!$p) {
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Produk - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: "Inter", sans-serif; }
        .font-serif { font-family: "Playfair Display", serif; }
    </style>
</head>
<body class="bg-pink-50/30 min-h-screen pb-20">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-pink-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-serif italic text-pink-800">
                Flowers.co <span class="text-xs font-sans not-italic text-slate-400 ml-2">Edit Produk</span>
            </h1>
            <a href="admin_dashboard.php" class="text-sm text-slate-500 hover:text-pink-600 transition">&larr; Kembali ke Dashboard</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto mt-10 px-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-pink-100/50 border border-pink-50">
            <h3 class="text-2xl font-serif italic text-slate-800 mb-8 text-center">Form Edit Produk</h3>
            <form action="proses_produk.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id" value="<?= $p['id']; ?>" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Bunga</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($p['nama_produk']); ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" />
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" value="<?= $p['harga']; ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kategori</label>
                        <select name="kategori" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm">
                            <option value="Anniversary" <?= $p['kategori'] == 'Anniversary' ? 'selected' : ''; ?>>Anniversary</option>
                            <option value="Ulang Tahun" <?= $p['kategori'] == 'Ulang Tahun' ? 'selected' : ''; ?>>Ulang Tahun</option>
                            <option value="Pernikahan" <?= $p['kategori'] == 'Pernikahan' ? 'selected' : ''; ?>>Pernikahan</option>
                            <option value="Wisuda" <?= $p['kategori'] == 'Wisuda' ? 'selected' : ''; ?>>Wisuda</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Stok Barang</label>
                        <input type="number" name="stok" value="<?= $p['stok']; ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Gambar Produk</label>
                    <div class="flex items-center gap-4">
                        <img src="img/<?= $p['gambar']; ?>" class="w-20 h-20 rounded-xl object-cover border" onerror="this.src='https://via.placeholder.com/150'">
                        <div class="flex-grow">
                            <input type="file" name="gambar" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-xs" />
                            <p class="text-[10px] text-gray-400 mt-1">*Kosongkan jika tidak ingin mengubah gambar</p>
                        </div>
                    </div>
                </div>

                <button type="submit" name="simpan" class="w-full py-4 bg-pink-500 text-white rounded-2xl font-bold shadow-lg shadow-pink-200 hover:bg-pink-600 transition-all active:scale-95 mt-4">
                    Simpan Perubahan Produk
                </button>
            </form>
        </div>
    </main>
</body>
</html>