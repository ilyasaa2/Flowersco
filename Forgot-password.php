<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pulihkan Akun - Flowers.co</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .font-serif {
      font-family: 'Playfair Display', serif;
    }

    .step-active {
      background-color: #d63384;
      border-color: #d63384;
    }
  </style>
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
  <div
    class="bg-white w-full max-w-4xl rounded-[3rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]">

    <div class="md:w-1/2 relative hidden md:block">
      <img src="images/PinkRoseBouquet.jpg" alt="Background" class="absolute inset-0 w-full h-full object-cover" />
      <div class="absolute inset-0 bg-pink-900/20"></div>
      <div class="absolute bottom-12 left-10 text-white z-10">
        <h2 class="text-4xl font-serif italic mb-2">Flowers Your Moment</h2>
        <p class="text-sm opacity-90 leading-relaxed max-w-xs">Jangan khawatir, kami akan membantu Anda mekar kembali
          dan mengakses akun Anda.</p>
      </div>
    </div>

    <div class="md:w-1/2 p-10 lg:p-16 flex flex-col justify-center bg-white relative">

      <div class="flex items-center space-x-3 mb-8">
        <div id="step1-circle"
          class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-bold step-active text-white transition-all duration-500">
          1</div>
        <div class="h-[2px] w-8 bg-gray-100"></div>
        <div id="step2-circle"
          class="w-8 h-8 rounded-full border-2 border-gray-100 flex items-center justify-center text-xs font-bold text-gray-300 transition-all duration-500">
          2</div>
      </div>

      <div id="step1-content" class="space-y-6">
        <div>
          <h1 class="text-3xl font-serif italic text-slate-800">Cek Inbox Kamu</h1>
          <p class="text-gray-400 text-sm mt-2 leading-relaxed">Masukkan email terdaftar. Kami akan mengirimkan <b>Magic
              Link</b> agar kamu bisa masuk tanpa password.</p>
        </div>
        <form id="magicLinkForm" class="space-y-6">
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email
              Terdaftar</label>
            <input type="email" name="email" id="forgotEmail" placeholder="nirmala@example.com"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
              required />
            <div id="emailError" class="text-[10px] text-red-500 mt-1 italic"></div>
          </div>
          <button type="submit"
            class="w-full py-4 bg-[#d63384] text-white rounded-xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-700 transition transform active:scale-95 flex items-center justify-center gap-2">
            Kirim Link Akses <i data-lucide="send" class="w-4 h-4"></i>
          </button>
        </form>
      </div>

      <div id="step2-content" class="hidden space-y-6 text-center animate-in fade-in zoom-in duration-500">
        <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-lucide="mail-check" class="w-10 h-10"></i>
        </div>
        <h2 class="text-2xl font-serif italic text-slate-800">Email Terkirim!</h2>
        <p class="text-gray-400 text-sm leading-relaxed">
          Silakan cek kotak masuk email Anda. Klik link di dalamnya untuk memulihkan akses secara instan.
        </p>

        <button id="resendBtn" onclick="resendLink()"
          class="text-pink-500 text-xs font-bold hover:underline mt-4 block mx-auto disabled:text-gray-300">
          Kirim ulang link
        </button>
      </div>
      <div class="text-center mt-10">
        <p class="text-xs text-gray-500">Ingat password Anda? <a href="Login.php"
            class="text-[#d63384] font-bold hover:underline">Masuk</a></p>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();
    const form = document.getElementById('magicLinkForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    let lastEmail = ""; // Variabel untuk menyimpan email

    // Fungsi utama kirim email
    async function sendMagicLink(email) {
      const formData = new FormData();
      formData.append('email', email);

      try {
        const response = await fetch('forgot_process.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();
        return result;
      } catch (err) {
        return { success: false, message: "Terjadi kesalahan server." };
      }
    }

    // Handler Form Pertama
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      const emailInput = document.getElementById('forgotEmail').value;
      lastEmail = emailInput; // Simpan email ke variabel

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Mengirim...';
      lucide.createIcons();

      const result = await sendMagicLink(lastEmail);

      if (result.success) {
        document.getElementById('step1-content').classList.add('hidden');
        document.getElementById('step2-content').classList.remove('hidden');
        document.getElementById('step2-circle').classList.add('step-active', 'text-white');
        document.getElementById('step2-circle').classList.remove('text-gray-300', 'border-gray-100');
      } else {
        document.getElementById('emailError').innerHTML = result.message;
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Kirim Link Akses <i data-lucide="send" class="w-4 h-4"></i>';
      }
      lucide.createIcons();
    });

    // Fungsi untuk Tombol Kirim Ulang di Step 2
    async function resendLink() {
      const resendBtn = document.getElementById('resendBtn');
      const originalText = resendBtn.innerHTML;

      resendBtn.disabled = true;
      resendBtn.innerHTML = "Mengirim ulang...";

      const result = await sendMagicLink(lastEmail);

      if (result.success) {
        alert("Link baru telah dikirim ke " + lastEmail);
        // Tambahkan cooldown sederhana
        let cooldown = 60;
        const timer = setInterval(() => {
          resendBtn.innerHTML = `Tunggu ${cooldown}s`;
          cooldown--;
          if (cooldown < 0) {
            clearInterval(timer);
            resendBtn.disabled = false;
            resendBtn.innerHTML = originalText;
          }
        }, 1000);
      } else {
        alert("Gagal mengirim ulang: " + result.message);
        resendBtn.disabled = false;
        resendBtn.innerHTML = originalText;
      }
    }
  </script>
</body>

</html>