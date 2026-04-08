<<?php
include 'config.php';
session_start();

if (!isset($_SESSION['login']) || $_SESSION['email'] !== 'flowerscomgl@gmail.com') {
    header("Location: Login.php");
    exit;
}

$query_pembayaran = mysqli_query($conn, "SELECT pembayaran.*, users.fullname FROM pembayaran 
                                JOIN users ON pembayaran.user_id = users.id 
                                WHERE status = 'pending' 
                                ORDER BY tanggal_bayar DESC");


$query_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

if (!$query_produk) {
    die("Gagal mengambil data produk: " . mysqli_error($conn));
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Flowers.co</title>
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
                Flowers.co <span class="text-xs font-sans not-italic text-slate-400 ml-2">Admin Mode</span>
            </h1>
            <a href="Katalog.php" class="text-sm text-slate-500 hover:text-pink-600 transition">Lihat Toko &rarr;</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto mt-10 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-pink-100/50 border border-pink-50">
                    <h3 class="text-xl font-serif italic text-slate-800 mb-6">Tambah Produk Baru</h3>
                    <form action="tambah_produk.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Bunga</label>
                            <input type="text" name="nama_produk" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" placeholder="Contoh: Pink Rose Bouquet" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga (Rp)</label>
                            <input type="number" name="harga" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" placeholder="150000" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Stok</label>
                            <input type="number" name="stok" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm" placeholder="10" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pilih Gambar</label>
                            <input type="file" name="gambar" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm" />
                        </div>
                        <button type="submit" name="submit" class="w-full py-3 bg-pink-500 text-white rounded-xl font-bold shadow-lg hover:bg-pink-600 transition mt-4">Simpan ke Database</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-pink-100/50 border border-pink-50">
                    <div class="p-6 bg-slate-800 text-white">
                        <h3 class="font-serif italic text-lg">Konfirmasi Pembayaran Pending</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-pink-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Metode</th>
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-pink-50">
                                <?php if(mysqli_num_rows($query_pembayaran) > 0) : ?>
                                    <?php while($row = mysqli_fetch_assoc($query_pembayaran)) : ?>
                                    <tr class="hover:bg-pink-50/20 transition">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-slate-700"><?= $row['fullname']; ?></div>
                                            <div class="text-[10px] text-slate-400"><?= $row['tanggal_bayar']; ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-500"><?= $row['metode_pembayaran']; ?></td>
                                        <td class="px-6 py-4 text-sm text-pink-600 font-bold">Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.'); ?></td>
                                        <td class="px-6 py-4">
                                            <a href="konfirmasi_proses.php?id=<?= $row['id_pembayaran']; ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')" 
                                            class="bg-green-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-600 transition shadow-md block text-center">
                                            Konfirmasi
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr><td colspan="4" class="p-10 text-center text-slate-400 italic">Tidak ada pembayaran tertunda.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
            </div>

                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-pink-100/50 border border-pink-50">
                    <div class="p-6 border-b border-pink-50">
                        <h3 class="text-slate-800 font-serif italic text-lg">Daftar Katalog Bunga (Database)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-pink-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">Produk</th>
                                    <th class="px-6 py-4">Harga</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-pink-50">
                                <?php 
                                // Kita jalankan query langsung di sini untuk memastikan data segar dari DB
                                $ambil_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                                
                                if(mysqli_num_rows($ambil_produk) > 0) : 
                                    while($p = mysqli_fetch_assoc($ambil_produk)) : 
                                ?>
                                <tr class="hover:bg-pink-50/20 transition">
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <?php 
                                            // Logika folder gambar: jika kolom gambar hanya berisi nama file
                                            $path_gambar = "img/" . $p['gambar']; 
                                        ?>
                                        <img src="<?= $path_gambar; ?>" class="w-12 h-12 rounded-lg object-cover shadow-sm" onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                                        <span class="font-semibold text-slate-700 text-sm"><?= htmlspecialchars($p['nama_produk']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-pink-600 font-bold">
                                        Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="hapus_produk.php?id=<?= $p['id']; ?>" 
                                        onclick="return confirm('Hapus produk ini?')" 
                                        class="text-red-400 hover:text-red-600 transition p-2 inline-block">
                                        Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                else : 
                                ?>
                                <tr>
                                    <td colspan="3" class="p-10 text-center text-slate-400 italic">
                                        Belum ada produk di database.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="md:w-2/3">
  <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-pink-100/50 border border-pink-50">
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="bg-pink-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
          <th class="px-6 py-4">Produk</th>
          <th class="px-6 py-4">Harga</th>
          <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-pink-50">
    <?php while($row = mysqli_fetch_assoc($query_produk)) : ?>
    <tr class="hover:bg-pink-50/20 transition">
        <td class="px-6 py-4 flex items-center gap-4">
            <img src="img/<?php echo $row['gambar']; ?>" class="w-12 h-12 rounded-lg object-cover shadow-sm">
            <span class="font-semibold text-slate-700 text-sm"><?php echo $row['nama_produk']; ?></span>
        </td>
        <td class="px-6 py-4 text-sm text-pink-600 font-bold">
            Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
        </td>
        <td class="px-6 py-4 text-center">
            <div class="flex justify-center gap-4">
                <a href="hapus_produk.php?id=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Yakin ingin menghapus produk ini?')"
                   class="text-red-500 hover:text-red-700 font-bold text-sm">
                   Hapus
                </a>
            </div>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>
    </table>
  </div>
</div>
                    
        
    </main>
</body>
</html>