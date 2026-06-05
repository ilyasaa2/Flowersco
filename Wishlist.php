<?php
include 'config.php';
if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wishlist Saya - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="bg-[#fff5f7] min-h-screen">
    <nav
      class="sticky top-0 z-50 flex justify-between items-center px-8 py-5 bg-white/80 backdrop-blur-md border-b border-pink-100"
    >
      <a
        href="Homepage.php"
        class="text-3xl font-serif text-pink-700 hover:opacity-80 transition-opacity cursor-pointer"
      >
        Flowers.co
      </a>
      <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-700">
        <a href="Homepage.php" class="hover:text-pink-600">Home</a>
        <a href="Katalog.php" class="hover:text-pink-600">Catalogue</a>
        <a href="AboutUs.php" class="hover:text-pink-600">About Us</a>
      </div>
      <div class="flex items-center gap-6 text-slate-600">
        <div class="relative group">
          <button class="flex items-center gap-2 hover:text-pink-600 text-lg py-2 focus:outline-none">
            👤
            <span class="hidden sm:block text-[10px] font-bold uppercase tracking-tighter text-slate-500">
              <?= htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?>
            </span>
          </button>
          <div class="absolute right-0 w-48 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[60]">
            <div class="bg-white border border-pink-100 rounded-2xl shadow-xl overflow-hidden">
              <?php if(isset($_SESSION['email']) && $_SESSION['email'] === 'flowerscomgl@gmail.com'): ?>
              <a href="admin_dashboard.php" class="flex items-center gap-3 px-4 py-3 text-sm text-pink-600 hover:bg-pink-50 font-bold transition">
                <span>⚙️</span> Admin Dashboard
              </a>
              <?php endif; ?>
              <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 font-bold transition">
                <span>➜</span> Logout Akun
              </a>
            </div>
          </div>
        </div>
        <a href="Wishlist.php" class="relative group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600 transition" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
          </svg>
          <span id="fav-count" class="absolute -top-1 -right-2 bg-[#ed4492] text-white text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">0</span>
        </a>
        <a href="Keranjang.php" class="relative group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-700 group-hover:text-pink-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <span id="cart-count" class="absolute -top-1 -right-2 bg-[#ed4492] text-white text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
              <?= (int)$total_keranjang; ?>
          </span>
        </a>
      </div>
    </nav>

    <main class="max-w-6xl mx-auto p-8">
      <header class="mb-12">
        <div class="flex items-center gap-3 mb-2">
          <span class="text-2xl">💖</span>
          <h2 class="text-3xl font-extrabold text-slate-800">
            Daftar Keinginan
          </h2>
        </div>
        <p class="text-slate-500 border-l-4 border-pink-200 pl-4">
          Simpan rangkaian bunga impianmu dan wujudkan momen spesial nanti.
        </p>
      </header>

      <div
        id="Wishlist-Container"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
      ></div>

      <div class="mt-20 text-center border-t border-pink-100 pt-10">
        <p class="text-slate-400 text-sm mb-4">
          Ingin melihat koleksi terbaru kami?
        </p>
        <a
          href="Katalog.php"
          class="inline-block bg-white border-2 border-pink-200 text-pink-600 px-8 py-3 rounded-full font-bold hover:bg-pink-50 transition-colors"
        >
          Lihat Semua Produk
        </a>
      </div>
    </main>

    <script src="main.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        if (typeof tampilkanWishlist === "function") {
          tampilkanWishlist();
        }
      });
    </script>
  </body>
</html>
