<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Plus Jakarta Sans", sans-serif;
      }
      .payment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 2px solid #f1f5f9;
      }
      .payment-card:hover {
        border-color: #fbcfe8;
        transform: translateY(-2px);
      }
      .selected-card {
        border-color: #ec4899 !important;
        background-color: #fff1f2;
        box-shadow: 0 0 0 4px #fce7f3;
      }
    </style>
  </head>
  <body class="bg-slate-50 min-h-screen pb-20 text-slate-800">
    <div class="max-w-6xl mx-auto px-4 py-12">
      <header class="mb-10 text-center lg:text-left">
        <h1 class="text-4xl font-bold text-slate-900 mb-2">
          Selesaikan Pembayaran ✨
        </h1>
        <p class="text-slate-500">
          Pilih metode pembayaran favoritmu untuk memproses pesanan.
        </p>
      </header>

      <div class="flex flex-col lg:flex-row gap-10">
        <div class="lg:w-2/3 space-y-10">
          <section>
            <div class="flex items-center gap-3 mb-5">
              <div
                class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center text-pink-600"
              >
                📱
              </div>
              <h3 class="text-xl font-bold">E-Wallet</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
              <div
                onclick="
                  selectPayment(
                    this,
                    'GoPay',
                    '0812-3456-7890',
                    'Flowers.co Official',
                  )
                "
                class="payment-card bg-white p-6 rounded-3xl shadow-sm flex flex-col items-center"
              >
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg"
                  class="h-8 mb-2"
                  alt="GoPay"
                />
                <span class="text-xs font-semibold text-slate-400">GoPay</span>
              </div>
              <div
                onclick="
                  selectPayment(
                    this,
                    'OVO',
                    '0812-3456-7890',
                    'Flowers.co Official',
                  )
                "
                class="payment-card bg-white p-6 rounded-3xl shadow-sm flex flex-col items-center"
              >
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
                  class="h-8 mb-2"
                  alt="OVO"
                />
                <span class="text-xs font-semibold text-slate-400">OVO</span>
              </div>
            </div>
          </section>

          <section>
            <div class="flex items-center gap-3 mb-5">
              <div
                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600"
              >
                🏦
              </div>
              <h3 class="text-xl font-bold">Transfer Bank</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
              <div
                onclick="
                  selectPayment(
                    this,
                    'Bank Mandiri',
                    '1122-3344-5566',
                    'Ilyasa Wicaksono',
                  )
                "
                class="payment-card bg-white p-6 rounded-3xl shadow-sm flex flex-col items-center"
              >
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                  class="h-8 mb-2"
                  alt="Mandiri"
                />
                <span class="text-xs font-semibold text-slate-400"
                  >Mandiri Transfer</span
                >
              </div>
            </div>
          </section>

          <section>
            <div class="flex items-center gap-3 mb-5">
              <div
                class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600"
              >
                🏪
              </div>
              <h3 class="text-xl font-bold">Gerai Retail</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
              <div
                onclick="
                  selectPayment(
                    this,
                    'Indomaret',
                    'FLW-IND-9921',
                    'Flowers.co Payment',
                  )
                "
                class="payment-card bg-white p-6 rounded-3xl shadow-sm flex flex-col items-center"
              >
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Logo_Indomaret.png"
                  class="h-8 mb-2"
                  alt="Indomaret"
                />
                <span class="text-xs font-semibold text-slate-400"
                  >Indomaret</span
                >
              </div>
              <div
                onclick="
                  selectPayment(
                    this,
                    'Alfamart',
                    'FLW-ALF-0032',
                    'Flowers.co Payment',
                  )
                "
                class="payment-card bg-white p-6 rounded-3xl shadow-sm flex flex-col items-center"
              >
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/8/86/Alfamart_logo.svg"
                  class="h-8 mb-2"
                  alt="Alfamart"
                />
                <span class="text-xs font-semibold text-slate-400"
                  >Alfamart</span
                >
              </div>
            </div>
          </section>

          <div
            id="instructionCard"
            class="hidden transform scale-95 opacity-0 transition-all duration-500 bg-white border-2 border-pink-100 p-8 rounded-[2.5rem] shadow-xl shadow-pink-50"
          >
            <div
              class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6"
            >
              <div>
                <p
                  class="text-pink-500 font-bold text-xs uppercase tracking-widest mb-1"
                >
                  Metode: <span id="targetName">...</span>
                </p>
                <h4
                  id="targetNumber"
                  class="text-3xl font-mono font-bold text-slate-800 tracking-tighter"
                >
                  0000 0000 0000
                </h4>
                <p class="text-slate-400 text-sm mt-1">
                  Atas Nama:
                  <span id="targetOwner" class="font-semibold text-slate-600"
                    >...</span
                  >
                </p>
              </div>
              <button
                onclick="copyNumber()"
                class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold hover:bg-slate-800 active:scale-95 transition-all"
              >
                Salin Kode
              </button>
            </div>
          </div>
        </div>

        <div class="lg:w-1/3">
          <div
            class="bg-white p-8 rounded-[3rem] shadow-2xl shadow-pink-100/50 border border-white sticky top-10"
          >
            <h3 class="text-2xl font-bold text-slate-800 mb-8">
              Detail Tagihan
            </h3>

            <div class="space-y-5 mb-8">
              <div class="flex justify-between items-center">
                <span class="text-slate-400 font-medium">Subtotal Produk</span>
                <span id="displayPrice" class="font-bold text-slate-700"
                  >Rp 0</span
                >
              </div>
              <div class="flex justify-between items-center">
                <span class="text-slate-400 font-medium">Biaya Layanan</span>
                <span id="adminFee" class="font-bold text-slate-700"
                  >Rp 2.500</span
                >
              </div>
              <div class="h-px bg-slate-100 w-full"></div>
              <div class="flex justify-between items-end">
                <div>
                  <p
                    class="text-[10px] font-bold text-pink-400 uppercase tracking-widest"
                  >
                    Total Bayar
                  </p>
                  <p id="totalPrice" class="text-3xl font-black text-pink-600">
                    Rp 0
                  </p>
                </div>
                <span class="text-[10px] text-slate-300 italic mb-1"
                  >Sudah termasuk PPN</span
                >
              </div>
            </div>

            <form method="POST" action="proses_pembayaran.php">
            <input type="hidden" name="transaksi_id" value="<?= rand(1000,9999) ?>">
            <input type="hidden" name="metode" id="metodeInput">
            <input type="hidden" name="jumlah" id="jumlahInput">

            <button
           type="button"
            onclick="confirmPayment()"
            class="w-full py-5 bg-[#ec4899] text-white rounded-3xl font-bold shadow-lg hover:bg-pink-600"
          >
          Bayar Sekarang
        </button>
</form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
        let subtotal = 0;
        const biayaAdmin = 2500;

        keranjang.forEach((item) => {
          const hargaMurni = parseInt(
            item.harga.toString().replace(/[^0-9]/g, ""),
          );
          subtotal += hargaMurni * item.jumlah;
        });

        const totalAkhir = subtotal + biayaAdmin;

        const formatRupiah = (angka) =>
          new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
          }).format(angka);

        document.getElementById("displayPrice").innerText =
          formatRupiah(subtotal);
        document.getElementById("adminFee").innerText =
          formatRupiah(biayaAdmin);
        document.getElementById("totalPrice").innerText =
          formatRupiah(totalAkhir);

        if (keranjang.length === 0) {
          alert("Ops! Keranjangmu kosong. Silakan belanja dulu.");
          window.location.href = "Katalog.html";
        }
      });

      function selectPayment(element, name, number, owner) {
        document
          .querySelectorAll(".payment-card")
          .forEach((c) => c.classList.remove("selected-card"));

        element.classList.add("selected-card");

        const instruction = document.getElementById("instructionCard");
        instruction.classList.remove("hidden");
        setTimeout(() => {
          instruction.classList.add("scale-100", "opacity-100");
        }, 50);

        document.getElementById("targetName").innerText = name;
        document.getElementById("targetNumber").innerText = number;
        document.getElementById("targetOwner").innerText = owner;

        if (window.innerWidth < 1024) {
          instruction.scrollIntoView({ behavior: "smooth", block: "center" });
        }
      }

      function copyNumber() {
        const num = document.getElementById("targetNumber").innerText;
        navigator.clipboard.writeText(num);
        alert("Nomor / Kode Bayar berhasil disalin ke clipboard! ");
      }
      function confirmPayment() {
  const metode = document.getElementById("targetName").innerText;

  if (metode === "...") {
    alert("Pilih metode pembayaran dulu!");
    return;
  }

  const total = document
    .getElementById("totalPrice")
    .innerText.replace(/[^0-9]/g, "");

  document.getElementById("metodeInput").value = metode;
  document.getElementById("jumlahInput").value = total;

  document.forms[0].submit();
}
    </script>
  </body>
</html>
