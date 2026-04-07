<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div
      class="bg-white w-full max-w-4xl rounded-[2.5rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]"
    >
      <div class="md:w-1/2 relative hidden md:block">
        <img
          src="images/PinkRoseBouquet.jpg"
          alt="Register Background"
          class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-pink-900/10"></div>
        <div class="absolute bottom-12 left-10 text-white z-10">
          <h2 class="text-4xl font-serif italic mb-2">Flowers Your Moment</h2>
          <p class="text-sm opacity-90 leading-relaxed max-w-xs">
            Karena setiap momen spesial pantas dirayakan dengan bunga terbaik.
          </p>
        </div>
      </div>

      <div class="md:w-1/2 p-10 flex flex-col justify-center">
        <div class="mb-8">
          <h1 class="text-3xl font-serif italic text-slate-800">Daftar Akun</h1>
          <p class="text-gray-400 text-sm mt-2">
            Bergabunglah untuk pengalaman belanja yang lebih personal.
          </p>
        </div>

        <form
          action="register_process.php"
          method="POST"
          id="registerForm"
          class="space-y-5"
          onsubmit="return validateForm();"
        >
          <div>
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Nama Lengkap</label
            >
            <input
              type="text"
              name="fullname"
              id="fullname"
              placeholder="Masukkan nama lengkap"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
              required
            />
          </div>

          <div>
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Email</label
            >
            <input
              type="email"
              name="email"
              id="email"
              placeholder="Masukkan email Anda"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
              required
            />
            <div
              id="emailError"
              class="text-[10px] text-red-500 mt-1 italic"
            ></div>
          </div>

          <div>
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Password</label
            >
            <div class="relative">
              <input
                type="password"
                name="password"
                id="password"
                placeholder="Buat password"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
                required
              />
              <button
                type="button"
                onclick="togglePass('password', 'eyeReg')"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  id="eyeReg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
              </button>
            </div>
            <div
              id="passwordError"
              class="text-[10px] text-red-500 mt-1 italic"
            ></div>
          </div>

          <div>
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Konfirmasi Password</label
            >
            <div class="relative">
              <input
                type="password"
                id="confirmPassword"
                placeholder="Ulangi password"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
                required
              />
              <button
                type="button"
                onclick="togglePass('confirmPassword', 'eyeConfirm')"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  id="eyeConfirm"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
              </button>
            </div>
            <div
              id="confirmError"
              class="text-[10px] text-red-500 mt-1 italic"
            ></div>
          </div>

          <button
            type="submit"
            name="register"
            class="w-full py-3 bg-[#d63384] text-white rounded-xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-700 transition transform hover:-translate-y-0.5 mt-4"
          >
            Daftar Sekarang
          </button>
        </form>

        <p class="text-center mt-8 text-xs text-gray-500">
          Sudah punya akun?
          <a href="Login.php" class="text-[#d63384] font-bold hover:underline"
            >Masuk di sini</a
          >
        </p>
      </div>
    </div>

    <script>
      function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
          input.type = "text";
          icon.classList.add("text-pink-500");
        } else {
          input.type = "password";
          icon.classList.remove("text-pink-500");
        }
      }

      function validateForm() {
        const password = document.getElementById("password").value;
        const confirm = document.getElementById("confirmPassword").value;
        const confirmError = document.getElementById("confirmError");

        confirmError.innerHTML = "";

        if (password !== confirm) {
          confirmError.innerHTML = "Password tidak cocok!";
          return false; // Menghentikan pengiriman form ke PHP
        }
        return true; // Form dikirim ke register_process.php
      }
    </script>
  </body>
</html>
