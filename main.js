const produkList = {
  "Pink Rose Bouquet": {
    harga: "$15.99",
    diskon: "$18.99",
    gambar: "images/PinkRoseBouquet.jpg",
    kategori: "aniversary",
  },
  "Calla Lily Bouquet": {
    harga: "$15.99",
    diskon: "$19.99",
    gambar: "images/CallaLilyBouquet.jpg",
    kategori: "wisuda",
  },
  "Cherry Blossom": {
    harga: "$18.50",
    diskon: "$22.00",
    gambar: "images/CherryBlossom.jpg",
    kategori: "ulangtahun",
  },
  "Lavender": {
    harga: "$12.99",
    diskon: "$15.00",
    gambar: "images/LavenderBouquet.jpg",
    kategori: "pernikahan",
  },
  "Sun Flower Box": {
    harga: "$20.00",
    diskon: "$25.00",
    gambar: "images/SunFlowerBox.jpg",
    kategori: "ELEGAN",
  },
  "White Tulip": {
    harga: "$17.99",
    diskon: "$21.00",
    gambar: "images/WhiteTulip.jpg",
    kategori: "wisuda",
  },
};

let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

document.addEventListener("DOMContentLoaded", function () {
  updateUI();

  if (document.getElementById("KatalogProduk")) {
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get("filter");

    if (filterParam) {
      filterProduk(filterParam);
    } else {
      renderKatalog("SEMUA");
    }
  }

  if (document.getElementById("Keranjang")) tampilkanKeranjang();
  if (document.getElementById("Wishlist-Container")) tampilkanWishlist();

  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      renderKatalog("SEMUA", e.target.value.toLowerCase());
    });
  }

  const loginBtn = document.getElementById("loginbtn");
  if (loginBtn) {
    loginBtn.addEventListener(
      "click",
      () => (window.location.href = "Login.html"),
    );
  }
});

function renderKatalog(filterKategori, searchKeyword = "") {
  const container = document.getElementById("KatalogProduk");
  if (!container) return;

  container.innerHTML = "";

  Object.keys(produkList).forEach((nama) => {
    const item = produkList[nama];
    const cocokKategori =
      filterKategori === "SEMUA" || item.kategori === filterKategori;
    const cocokSearch = nama.toLowerCase().includes(searchKeyword);

    if (cocokKategori && cocokSearch) {
      const isFav = wishlist.includes(nama);
      container.innerHTML += `
                <div class="group bg-white rounded-[2.5rem] p-4 border border-pink-50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="relative overflow-hidden rounded-[2rem] bg-pink-50 h-72 mb-4">
                        <img src="${item.gambar}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500" />
                        <button onclick="tambahFavorit('${nama}')" class="absolute top-4 right-4 bg-white/90 p-2.5 rounded-full shadow-md hover:scale-110 transition-all ${isFav ? "text-pink-600" : "text-gray-300"}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="${isFav ? "currentColor" : "none"}" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-center px-2">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-pink-400 font-bold mb-1">${item.kategori}</p>
                        <h4 class="font-serif text-lg text-slate-800 mb-2 h-12 flex items-center justify-center">${nama}</h4>
                        <div class="flex justify-center items-center gap-2 mb-4">
                            <span class="text-pink-600 font-extrabold text-xl">${item.harga}</span>
                            <span class="text-gray-300 line-through text-xs">${item.diskon}</span>
                        </div>
                        <button onclick="tambahKeranjang('${nama}')" class="w-full py-3.5 bg-pink-500 text-white rounded-2xl font-bold hover:bg-pink-600 transition shadow-lg shadow-pink-100 active:scale-95">
                            Add to bag
                        </button>
                    </div>
                </div>`;
    }
  });
}

function filterProduk(kategori) {
  document.querySelectorAll("#categoryList li").forEach((li) => {
    li.classList.remove("category-active", "text-pink-600", "font-bold");
    if (li.getAttribute("data-cat") === kategori)
      li.classList.add("category-active", "text-pink-600", "font-bold");
  });
  renderKatalog(kategori);
}

function tambahKeranjang(namaProduk) {
  const detail = produkList[namaProduk];
  if (detail) {
    const index = keranjang.findIndex((item) => item.nama === namaProduk);
    if (index !== -1) {
      keranjang[index].jumlah += 1;
    } else {
      keranjang.push({
        nama: namaProduk,
        harga: detail.harga,
        gambar: detail.gambar,
        jumlah: 1,
      });
    }
    simpanDanUpdate();

    showNotification(`🛒 ${namaProduk} ditambahkan ke Keranjang!`);

    if (document.getElementById("Keranjang")) tampilkanKeranjang();
  }
}

function tampilkanKeranjang() {
  const kontainer = document.getElementById("Keranjang");
  const actions = document.getElementById("cart-actions");
  const totalDisplay = document.getElementById("total-harga");
  if (totalDisplay) {
    const totalSemua = keranjang.reduce((acc, item) => {
      return acc + getHargaAngka(item.harga) * item.jumlah;
    }, 0);

    totalDisplay.textContent = `$${totalSemua.toFixed(2)}`;
  }

  if (!kontainer) return;
  kontainer.innerHTML = "";
  let totalJelajah = 0;

  if (keranjang.length === 0) {
    if (actions) actions.classList.add("hidden");
    kontainer.innerHTML = `
        <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white/40 rounded-[3rem] border-2 border-dashed border-pink-200 animate-fade-in">
            <div class="text-7xl mb-6">💐</div>
            <h2 class="text-2xl font-serif text-slate-800 mb-2">Oops! Keranjangmu masih kosong</h2>
            <p class="text-slate-500 mb-8 text-center max-w-md">
                Sepertinya kamu belum memilih bunga cantik untuk hari ini. Yuk, intip koleksi terbaru kami!
            </p>
            <a href="Katalog.html" class="px-10 py-4 bg-pink-500 text-white rounded-full font-bold shadow-lg shadow-pink-200 hover:bg-pink-600 hover:scale-105 transition-all duration-300">
                Lihat Koleksi Bunga →
            </a>
        </div>`;
    return;
  }

  if (actions) actions.classList.remove("hidden");

  keranjang.forEach((item, index) => {
    const hargaSatuan = getHargaAngka(item.harga);
    const subtotal = hargaSatuan * item.jumlah;
    totalJelajah += subtotal;

    kontainer.innerHTML += `
            <div class="bg-white rounded-[2.5rem] p-5 shadow-sm border border-pink-50 flex flex-col relative group">
                <div class="relative h-64 overflow-hidden rounded-[1.8rem] mb-4">
                    <img src="${item.gambar}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" />
                    <button onclick="hapusItem(${index})" class="absolute top-3 right-3 bg-white/90 p-2 rounded-full text-red-400 shadow-md hover:bg-red-500 hover:text-white transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-8 4h12m-5 4v6m-4-6v6" /></svg>
                    </button>
                </div>
                
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">${item.nama}</h3>
                        <p class="text-pink-600 font-bold">$${subtotal.toFixed(2)}</p>
                    </div>
                    
                    <div class="flex items-center gap-3 bg-pink-50 px-3 py-1.5 rounded-full border border-pink-100">
                        <button onclick="ubahJumlah(${index}, -1)" class="w-6 h-6 flex items-center justify-center bg-white rounded-full shadow-sm text-pink-600 hover:bg-pink-500 hover:text-white transition-all">-</button>
                        <span class="font-bold text-slate-700 min-w-[20px] text-center">${item.jumlah}</span>
                        <button onclick="ubahJumlah(${index}, 1)" class="w-6 h-6 flex items-center justify-center bg-white rounded-full shadow-sm text-pink-600 hover:bg-pink-500 hover:text-white transition-all">+</button>
                    </div>
                </div>
            </div>`;
  });

  if (totalDisplay) {
    totalDisplay.textContent = `$${totalJelajah.toFixed(2)}`;
  }
}

function tambahFavorit(namaProduk) {
  const index = wishlist.indexOf(namaProduk);
  let pesan = "";

  const btn = event.currentTarget;
  btn.classList.add("animate-pop");
  setTimeout(() => btn.classList.remove("animate-pop"), 400);

  if (index === -1) {
    wishlist.push(namaProduk);
    pesan = `💖 ${namaProduk} ditambahkan ke Wishlist!`;
  } else {
    wishlist.splice(index, 1);
    pesan = `💔 ${namaProduk} dihapus dari Wishlist.`;
  }

  simpanDanUpdate();
  showNotification(pesan);

  if (document.getElementById("KatalogProduk")) {
    const activeCat =
      document.querySelector(".category-active")?.getAttribute("data-cat") ||
      "SEMUA";
    renderKatalog(activeCat);
  }

  if (document.getElementById("Wishlist-Container")) {
    tampilkanWishlist();
  }
}

function showNotification(message) {
  const oldToast = document.getElementById("toast-msg");
  if (oldToast) oldToast.remove();

  const toast = document.createElement("div");
  toast.id = "toast-msg";
  toast.className = `fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] bg-slate-900 text-white px-6 py-3 rounded-full shadow-2xl font-medium flex items-center gap-3 animate-slide-up`;
  toast.innerHTML = `<span>${message}</span>`;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("opacity-0", "translate-y-4");
    toast.classList.replace("animate-slide-up", "transition-all");
    setTimeout(() => toast.remove(), 500);
  }, 3000);
}

function tampilkanWishlist() {
  const kontainer = document.getElementById("Wishlist-Container");
  if (!kontainer) return;

  kontainer.innerHTML = "";

  if (wishlist.length === 0) {
    kontainer.innerHTML = `
            <div class="col-span-full text-center py-20 bg-pink-50 rounded-[3rem] border-2 border-dashed border-pink-200">
                <span class="text-6xl mb-6 inline-block">💖</span>
                <p class="text-2xl font-serif italic text-slate-500 mb-2">Wishlist Anda masih kosong</p>
                <a href="Katalog.html" class="inline-block mt-4 bg-pink-600 text-white px-10 py-3 rounded-full font-bold shadow-lg">Cari Bunga</a>
            </div>`;
    return;
  }

  wishlist.forEach((namaProduk) => {
    const detail = produkList[namaProduk];
    if (detail) {
      kontainer.innerHTML += `
                <div class="group bg-white rounded-[2.5rem] p-4 border border-pink-50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="relative overflow-hidden rounded-[2rem] bg-pink-50 h-72 mb-4">
                        <img src="${detail.gambar}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500" />
                        <button onclick="tambahFavorit('${namaProduk}')" class="absolute top-4 right-4 bg-white/90 p-2.5 rounded-full shadow-md text-pink-600 hover:bg-pink-500 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="text-center px-2">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-pink-400 font-bold mb-1">${detail.kategori}</p>
                        <h4 class="font-serif text-lg text-slate-800 mb-2 h-12 flex items-center justify-center">${namaProduk}</h4>
                        <p class="text-pink-600 font-extrabold text-xl mb-4">${detail.harga}</p>
                        <button onclick="tambahKeranjang('${namaProduk}')" class="w-full py-3.5 bg-pink-500 text-white rounded-2xl font-bold hover:bg-pink-600 transition shadow-lg shadow-pink-100 active:scale-95">
                            Add to bag
                        </button>
                    </div>
                </div>`;
    }
  });
}

function hapusItem(index) {
  keranjang.splice(index, 1);
  simpanDanUpdate();
  tampilkanKeranjang();
}

function simpanDanUpdate() {
  localStorage.setItem("keranjang", JSON.stringify(keranjang));
  localStorage.setItem("wishlist", JSON.stringify(wishlist));
  updateUI();
}

function updateUI() {
  const cartCount = document.getElementById("cart-count");
  const favCount = document.getElementById("fav-count");

  if (cartCount) cartCount.textContent = keranjang.length;
  if (favCount) favCount.textContent = wishlist.length;
}

function resetKeranjang() {
  if (confirm("Kosongkan keranjang?")) {
    keranjang = [];
    simpanDanUpdate();
    if (document.getElementById("Keranjang")) tampilkanKeranjang();
  }
}

function getHargaAngka(hargaString) {
  if (!hargaString) return 0;
  if (typeof hargaString === "number") return hargaString;

  const angka = hargaString.replace(/[^0-9.]/g, "");
  return parseFloat(angka) || 0;
}

function checkoutWhatsApp() {
  if (keranjang.length === 0) {
    showNotification("Keranjang Anda masih kosong!");
    return;
  }

  const phoneNumber = "6285184709553";

  let pesanWA = " *PESANAN BARU - FLOWERS.CO* \n";
  pesanWA += "------------------------------------------\n\n";
  pesanWA += "Halo Admin, saya ingin memesan rangkaian bunga berikut:\n\n";

  let totalHarga = 0;

  keranjang.forEach((item, index) => {
    const subtotal = getHargaAngka(item.harga) * item.jumlah;
    pesanWA += `*${index + 1}. ${item.nama}*\n`;
    pesanWA += `   Jumlah: ${item.jumlah}x\n`;
    pesanWA += `   Subtotal: $${subtotal.toFixed(2)}\n\n`;
    totalHarga += subtotal;
  });

  pesanWA += "------------------------------------------\n";
  pesanWA += `*TOTAL PEMBAYARAN: $${totalHarga.toFixed(2)}*\n\n`;
  pesanWA +=
    "Mohon info ketersediaan stok dan metode pengirimannya. Terima kasih!";

  const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(pesanWA)}`;

  window.open(url, "_blank");
}

function ubahJumlah(index, perubahan) {
  keranjang[index].jumlah += perubahan;

  if (keranjang[index].jumlah < 1) {
    if (confirm(`Hapus ${keranjang[index].nama} dari keranjang?`)) {
      keranjang.splice(index, 1);
    } else {
      keranjang[index].jumlah = 1; // Kembalikan ke 1 jika batal
    }
  }

  simpanDanUpdate();
  tampilkanKeranjang();
}

////coba
const params = new URLSearchParams(window.location.search);
const filter = params.get("filter");

if (filter) {
  filterProduk(filter);
}
