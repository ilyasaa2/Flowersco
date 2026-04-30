<?php
include 'config.php';
session_start();

// Ambil data produk dari database
// Kita ambil berdasarkan ID DESC agar produk terbaru muncul di paling atas
$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
      body { font-family: "Inter", sans-serif; }
      .font-serif { font-family: "Playfair Display", serif; }
      .category-active {
        color: #db2777;
        font-weight: 700;
        background-color: #fdf2f8;
        border-radius: 9999px;
        padding-left: 12px;
      }
    </style>
  </head>
  <body class="bg-white">
    <header class="border-b">
      <nav class="bg-white sticky top-0 z-50 shadow">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
          <a href="Homepage.php" class="text-3xl font-serif text-pink-700 hover:opacity-80 transition-opacity cursor-pointer">
            Flowers.co
          </a>

          <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-700">
            <a href="Homepage.php" class="hover:text-pink-600">Home</a>
            <a href="Katalog.php" class="hover:text-pink-600 font-semibold text-pink-700">Catalogue</a>
            <a href="AboutUs.php" class="hover:text-pink-600">About Us</a>
          </div>

          <div class="flex items-center gap-6 text-slate-600">
            <div class="relative group">
              <button class="flex items-center gap-2 hover:text-pink-600 text-lg py-2 focus:outline-none">
                👤
                <span class="hidden sm:block text-[10px] font-bold uppercase tracking-tighter text-slate-500">
                  <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?>
                </span>
              </button>
              <div class="absolute right-0 w-40 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[60]">
                <div class="bg-white border border-pink-100 rounded-2xl shadow-xl overflow-hidden">
                  <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 font-bold transition">
                    <span>➜</span> Logout Akun
                  </a>
                </div>
              </div>
            </div>

            <a href="Wishlist.php" class="relative group">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-slate-700 group-hover:text-pink-600 transition"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
              />
            </svg>
            <span
              id="fav-count"
              class="absolute -top-1 -right-2 bg-[#ed4492] text-white text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white"
              >0</span
            >
          </a>

            <a href="Keranjang.php" class="relative group">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-700 group-hover:text-pink-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </a>
          </div>
        </div>
      </nav>
      <div class="py-12 bg-pink-50 border-b border-pink-100">
        <div class="container mx-auto px-6 text-center">
          <h2 class="text-5xl font-serif italic text-pink-600 mb-2">Catalogue</h2>
          <p class="text-gray-400 italic font-light">Temukan buket yang sempurna untuk setiap acara</p>
        </div>
      </div>
    </header>

    <main class="container mx-auto px-6 py-10 flex flex-col md:flex-row gap-8">
      <aside class="w-full md:w-1/4">
        <div class="bg-white p-6 rounded-3xl border border-pink-100 shadow-sm sticky top-24">
          <input type="text" id="searchInput" placeholder="Cari Produk..." class="w-full px-5 py-3 border border-pink-100 rounded-full focus:ring-2 focus:ring-pink-300 outline-none mb-8 text-sm transition-all" />
          <h3 class="font-serif italic text-xl text-pink-600 mb-4 border-b border-pink-50 pb-2">Kategori</h3>
          <ul class="space-y-2 text-gray-500 font-medium">
            <li class="flex items-center gap-3 p-2 hover:text-pink-500 cursor-pointer transition-all category-active">✨ Semua Produk</li>
            <li class="flex items-center gap-3 p-2 hover:text-pink-500 cursor-pointer transition-all"><span>💗</span> Anniversary</li>
            <li class="flex items-center gap-3 p-2 hover:text-pink-500 cursor-pointer transition-all"><span>🎂</span> Ulang Tahun</li>
            <li class="flex items-center gap-3 p-2 hover:text-pink-500 cursor-pointer transition-all"><span>💒</span> Pernikahan</li>
            <li class="flex items-center gap-3 p-2 hover:text-pink-500 cursor-pointer transition-all"><span>🎓</span> Wisuda</li>
          </ul>
        </div>
      </aside>

      <section class="w-full md:w-3/4">
        <div id="KatalogProduk" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-500">
          
          <?php while($row = mysqli_fetch_assoc($query)) : ?>
          <div class="bg-white p-4 rounded-[2.5rem] border border-pink-50 shadow-sm hover:shadow-2xl hover:shadow-pink-100/50 transition-all duration-500 group">
            <div class="relative overflow-hidden rounded-[2rem] mb-4 aspect-square">
              <img src="img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_produk']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
            </div>
            
            <div class="px-2">
              <h3 class="font-serif italic text-xl text-slate-800 mb-1"><?php echo $row['nama_produk']; ?></h3>
              <p class="text-pink-600 font-bold text-lg mb-4">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
              
              <form action="tambah_keranjang.php" method="POST">
                <input type="hidden" name="nama_produk" value="<?php echo $row['nama_produk']; ?>">
                <input type="hidden" name="harga" value="<?php echo $row['harga']; ?>">
                <input type="hidden" name="gambar" value="<?php echo $row['gambar']; ?>">
                <input type="hidden" name="jumlah" value="1">
                <button type="submit" name="tambah_keranjang" class="w-full py-3 bg-pink-50 text-pink-600 rounded-2xl font-bold hover:bg-pink-500 hover:text-white transition-all transform active:scale-95 shadow-sm">
                  + Keranjang
                </button>
              </form>
            </div>
          </div>
          <?php endwhile; ?>

        </div>
      </section>
    </main>

    <script>
      document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('#KatalogProduk > div');
        
        cards.forEach(card => {
          let name = card.querySelector('h3').innerText.toLowerCase();
          if(name.includes(filter)) {
            card.style.display = "";
          } else {
            card.style.display = "none";
          }
        });
      });
    </script>
  </body>
</html>