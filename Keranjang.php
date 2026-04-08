<?php
include 'config.php';
session_start();

// 1. Cek Login
if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Ambil data keranjang asli dari Database
$query = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'");
$total_estimasi = 0;
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: "Plus Jakarta Sans", sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>

<body class="bg-[#fff5f7] min-h-screen">
    <nav class="sticky top-0 z-50 flex justify-between items-center px-8 py-5 bg-white/80 backdrop-blur-md border-b border-pink-100">
        <a href="Homepage.php" class="text-3xl font-serif text-pink-700 hover:opacity-80 transition-opacity cursor-pointer">
            Flowers.co
        </a>
        <a href="Katalog.php" class="group flex items-center gap-2 text-pink-600 font-semibold hover:text-pink-700 transition">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            Kembali Belanja
        </a>
    </nav>

    <main class="max-w-6xl mx-auto p-8">
        <header class="mb-12">
            <h2 class="text-3xl font-extrabold text-slate-800">Keranjang Belanja</h2>
            <p class="text-slate-500">Tinjau rangkaian bunga pilihan anda sebelum check-out</p>
        </header>

        <form action="proses_pembayaran.php" method="POST">
            <div id="Keranjang" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (mysqli_num_rows($query) > 0) : ?>
                    <?php while ($item = mysqli_fetch_assoc($query)) : 
                        $subtotal = $item['harga'] * $item['jumlah'];
                        $total_estimasi += $subtotal;
                    ?>
                        <div class="glass-card p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                            <img src="img/<?= $item['gambar']; ?>" class="w-full h-48 object-cover rounded-2xl mb-4" alt="">
                            <h3 class="text-xl font-bold text-slate-800"><?= $item['nama_produk']; ?></h3>
                            <p class="text-pink-600 font-semibold mb-2">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-pink-50">
                                <span class="text-slate-500 text-sm">Jumlah: <?= $item['jumlah']; ?></span>
                                <span class="font-bold text-slate-800">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-span-full text-center py-20">
                        <p class="text-slate-400 italic">Transaksi Anda sedang diproses</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($total_estimasi > 0) : ?>
                <div class="mt-16 flex flex-col items-center gap-6 max-w-md mx-auto">
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-bold text-slate-700">Metode Pembayaran:</label>
                        <select name="metode" required class="w-full p-4 rounded-2xl border-2 border-pink-100 focus:border-pink-500 outline-none transition-all">
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="Transfer BCA">Transfer BCA</option>
                            <option value="OVO / Dana">OVO / Dana</option>
                            <option value="COD">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <div class="w-full flex justify-between items-center px-4">
                        <span class="text-slate-500 font-medium">Total (Belum inc. Admin)</span>
                        <span class="text-2xl font-bold text-pink-600">Rp <?= number_format($total_estimasi, 0, ',', '.'); ?></span>
                    </div>

                    <button type="submit" class="w-full py-4 bg-pink-500 text-white rounded-full font-bold shadow-lg hover:bg-pink-600 transition-all active:scale-95">
                        Lanjutkan Pembayaran →
                    </button>
                    
                    <a href="hapus_semua_keranjang.php" class="text-slate-400 text-sm hover:text-red-500 transition underline" onclick="return confirm('Kosongkan semua item?')">
                        Kosongkan Keranjang
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>