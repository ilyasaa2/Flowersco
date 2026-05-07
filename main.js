const produkList = {
  "Pink Rose Bouquet": {
    harga: "Rp 200.000",
    diskon: "RP 220.000",
    gambar: "images/PinkRoseBouquet.jpg",
    kategori: "anniversary",
  },
  "Calla Lily Bouquet": {
    harga: "Rp 180.000",
    diskon: "RP 215.000",
    gambar: "images/CallaLilyBouquet.jpg",
    kategori: "wisuda",
  },
  "Cherry Blossom": {
    harga: "Rp 195.000",
    diskon: "RP 235.000",
    gambar: "images/CherryBlossom.jpg",
    kategori: "ulang tahun",
  },
  "Lavender": {
    harga: "Rp 210.000",
    diskon: "RP 250.000",
    gambar: "images/LavenderBouquet.jpg",
    kategori: "pernikahan",
  },
  "White Tulip": {
    harga: "Rp 170.000",
    diskon: "RP 200.000",
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
    filterParam ? filterProduk(filterParam) : renderKatalog("SEMUA");
  }

  if (document.getElementById("Keranjang")) renderKeranjang();
  if (document.getElementById("Wishlist-Container")) tampilkanWishlist();

  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", (e) => renderKatalog("SEMUA", e.target.value.toLowerCase()));
  }
});

const loginBtn = document.getElementById("loginbtn");
  if (loginBtn) {
    loginBtn.addEventListener(
      "click",
      () => (window.location.href = "Login.html"),
    );
  };

function renderKatalog(filterKategori, searchKeyword = "") {
  const container = document.getElementById("KatalogProduk");
  if (!container) return;
  container.innerHTML = "";

  Object.keys(produkList).forEach((nama) => {
    const item = produkList[nama];
    const cocokKategori = filterKategori === "SEMUA" || item.kategori === filterKategori;
    const cocokSearch = nama.toLowerCase().includes(searchKeyword);

    if (cocokKategori && cocokSearch) {
      const isFav = wishlist.includes(nama);
      container.innerHTML += `
        <div class="group bg-white rounded-[2.5rem] p-4 border border-pink-50 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="relative overflow-hidden rounded-[2rem] bg-pink-50 h-72 mb-4">
                <img src="${item.gambar}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500" />
                <button onclick="tambahFavorit('${nama}')" class="absolute top-4 right-4 bg-white/90 p-2.5 rounded-full shadow-md ${isFav ? "text-pink-600" : "text-gray-300"}">
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
                </div>
                <button onclick="tambahKeranjang('${nama}')" class="w-full py-3.5 bg-pink-500 text-white rounded-2xl font-bold hover:bg-pink-600 transition shadow-lg active:scale-95">
                    Tambah ke Keranjang
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

function renderKeranjang() {
  const container = document.getElementById("Keranjang");
  const actions = document.getElementById("cart-actions");
  const estimasiEl = document.getElementById("total-estimasi"); // Sesuai ID di gambar kamu sebelumnya
  
  keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

  if (!container) return;

  if (keranjang.length === 0) {
    if (actions) actions.classList.add("hidden");
    container.innerHTML = `
        <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white/40 rounded-[3rem] border-2 border-dashed border-pink-200 animate-fade-in">
            <div class="text-7xl mb-6">🛒</div>
            <h2 class="text-2xl font-serif text-slate-800 mb-2">Oops! Keranjangmu masih kosong</h2>
            <p class="text-slate-500 mb-8 text-center max-w-md">
                Sepertinya kamu belum memilih bunga cantik untuk hari ini. Yuk, intip koleksi terbaru kami!
            </p>
            <a href="Katalog.html" class="px-10 py-4 bg-pink-500 text-white rounded-full font-bold shadow-lg shadow-pink-200 hover:bg-pink-600 hover:scale-105 transition-all duration-300">
                Lihat Koleksi Bunga →
            </a>
        </div>`;
    if (estimasiEl) estimasiEl.innerText = "Rp 0";
    return;
  }

  if (actions) actions.classList.remove("hidden");
  container.innerHTML = "";
  let totalHarga = 0;

  keranjang.forEach((item, index) => {
    const hargaAngka = getHargaAngka(item.harga);
    const subtotal = hargaAngka * item.jumlah;
    totalHarga += subtotal;

    container.innerHTML += `
      <div class="product-card bg-white p-6 rounded-[2.5rem] shadow-sm relative group">
          <button onclick="hapusItem(${index})" class="absolute top-4 right-4 bg-white/90 p-2 rounded-full text-red-400 shadow-md hover:bg-red-500 hover:text-white transition-all">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-8 4h12m-5 4v6m-4-6v6" /></svg>
          </button>
          <div class="overflow-hidden rounded-[1.8rem] mb-4 aspect-square">
              <img src="${item.gambar}" class="w-full h-full object-cover">
          </div>
          <h3 class="font-bold text-slate-800">${item.nama}</h3>
          <p class="text-pink-600 font-bold mb-4">Rp ${subtotal.toLocaleString("id-ID")}</p>
          
          <div class="flex items-center justify-between bg-pink-50 px-3 py-1.5 rounded-full border border-pink-100">
              <div class="flex items-center gap-4 w-full justify-between">
                  <button onclick="ubahQty(${index}, -1)" class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-sm text-pink-600 hover:bg-pink-500 hover:text-white transition-all">-</button>
                  <span class="font-bold text-slate-700">${item.jumlah}</span>
                  <button onclick="ubahQty(${index}, 1)" class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-sm text-pink-600 hover:bg-pink-500 hover:text-white transition-all">+</button>
              </div>
          </div>
      </div>`;
  });

  if (estimasiEl) {
    estimasiEl.innerText = `Rp ${totalHarga.toLocaleString("id-ID")}`;
  }
  localStorage.setItem("totalTagihan", totalHarga);
}

function resetKeranjang() {
  if (confirm("Kosongkan keranjang?")) {
    keranjang = [];
    simpanDanUpdate();
    if (document.getElementById("Keranjang")) tampilkanKeranjang();
  }
}

function tambahKeranjang(namaProduk) {
    const detail = produkList[namaProduk];
    const formData = new FormData();
    formData.append('tambah_keranjang', true);
    formData.append('nama_produk', namaProduk);
    formData.append('harga', detail.harga);
    formData.append('jumlah', 1);
    formData.append('gambar', detail.gambar);

    fetch('proses_keranjang.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "Berhasil") {
            showNotification(`${namaProduk} ditambahkan!`);
        }
    });
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
            <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white/40 rounded-[3rem] border-2 border-dashed border-pink-200 animate-fade-in">
            <div class="text-7xl mb-6">❤️</div>
            <h2 class="text-2xl font-serif text-slate-800 mb-2">Wishlist Anda Masih Kosong!</h2>
            <p class="text-slate-500 mb-8 text-center max-w-md">
                Sepertinya kamu belum memilih bunga cantik untuk hari ini. Yuk, intip koleksi terbaru kami!
            </p>
            <a href="Katalog.html" class="px-10 py-4 bg-pink-500 text-white rounded-full font-bold shadow-lg shadow-pink-200 hover:bg-pink-600 hover:scale-105 transition-all duration-300">
                Lihat Koleksi Bunga →
            </a>
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
};

function simpanDanUpdate() {
  localStorage.setItem("keranjang", JSON.stringify(keranjang));
  localStorage.setItem("wishlist", JSON.stringify(wishlist));
  updateUI();
};

function updateUI() {
  const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
  const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
  const cartCount = document.getElementById("cart-count");
  const favCount = document.getElementById("fav-count");

  if (cartCount) cartCount.textContent = keranjang.length;
  if (favCount) favCount.textContent = wishlist.length;
};

function getHargaAngka(hargaString) {
  if (!hargaString) return 0;
  if (typeof hargaString === "number") return hargaString;
  return parseInt(hargaString.replace(/[^0-9]/g, "")) || 0;
};

window.prosesKePembayaran = function() {
    const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

    if (keranjang.length === 0) {
        alert("Keranjang kamu masih kosong, pilih bunga dulu yuk!");
        window.location.href = "Katalog.html";
        return;
    }

    let totalTagihan = 0;
    keranjang.forEach(item => {
        const hargaMurni = parseInt(item.harga.toString().replace(/[^0-9]/g, ""));
        totalTagihan += hargaMurni * item.jumlah;
    });

    localStorage.setItem("totalTagihan", totalTagihan);

    window.location.href = "Pembayaran.html";
};

window.resetKeranjang = function() {
    if (confirm("Apakah anda yakin ingin mengosongkan keranjang?")) {
        localStorage.removeItem("keranjang");
        localStorage.removeItem("totalTagihan");
        location.reload(); 
    }
};

window.ubahQty = function(index, delta) {
  let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
  if (keranjang[index]) {
    keranjang[index].jumlah += delta;
    if (keranjang[index].jumlah < 1) {
      keranjang.splice(index, 1);
    }
    localStorage.setItem("keranjang", JSON.stringify(keranjang));
    renderKeranjang(); 
    updateUI(); 
  }
};

window.hapusItem = function(index) {
  let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
  keranjang.splice(index, 1);
  localStorage.setItem("keranjang", JSON.stringify(keranjang));
  renderKeranjang();
  updateUI();
};

