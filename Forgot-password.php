<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/lucide@latest"></script>
  </head>
  <body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div
      class="bg-white w-full max-w-4xl rounded-[3rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]"
    >
      <div class="md:w-1/2 relative hidden md:block">
        <img
          src="images/PinkRoseBouquet.jpg"
          alt="Forgot Password Background"
          class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-pink-900/10"></div>
        <div class="absolute bottom-12 left-10 text-white z-10">
          <h2 class="text-4xl font-serif italic mb-2">Flowers Your Moment</h2>
          <p class="text-sm opacity-90 leading-relaxed max-w-xs">
            Jangan khawatir, kami akan membantu Anda kembali ke akun Anda.
          </p>
        </div>
      </div>

      <div class="md:w-1/2 p-10 lg:p-16 flex flex-col justify-center bg-white">
        <div class="mb-10">
          <h1 class="text-3xl font-serif italic text-slate-800">
            Pulihkan Akun
          </h1>
          <p class="text-gray-400 text-sm mt-2 leading-relaxed">
            Masukkan email Anda dan buat password baru untuk memulihkan akses.
          </p>
        </div>

        <form
          action="forgot_process.php"
          method="POST"
          class="space-y-6"
          onsubmit="return validateForgot();"
        >
          <div>
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Email Terdaftar</label
            >
            <input
              type="email"
              name="email"
              id="forgotEmail"
              placeholder="Masukkan Email Anda"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
              required
            />
            <div
              id="forgotEmailError"
              class="text-[10px] text-red-500 mt-1 italic"
            ></div>
          </div>

          <div class="relative">
            <label
              class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"
              >Password Baru</label
            >
            <div class="relative">
              <input
                type="password"
                name="new_password"
                id="newPassword"
                placeholder="Masukkan Password Baru"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm pr-12"
                required
              />

              <button
                type="button"
                onclick="togglePassword()"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500 transition-colors"
              >
                <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
              </button>
            </div>
          </div>

          <button
            type="submit"
            name="reset"
            class="w-full py-4 bg-[#d63384] text-white rounded-xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-700 transition transform active:scale-95 mt-4"
          >
            Update Password
          </button>
        </form>

        <div class="text-center mt-10 space-y-2">
          <p class="text-xs text-gray-500">
            Ingat password Anda?
            <a href="Login.php" class="text-[#d63384] font-bold hover:underline"
              >Masuk</a
            >
          </p>
        </div>
      </div>
    </div>

    <script>
      function validateForgot() {
        const email = document.getElementById("forgotEmail").value;
        const errorDiv = document.getElementById("forgotEmailError");
        errorDiv.innerHTML = "";

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
          errorDiv.innerHTML = "Format email tidak valid!";
          return false;
        }
        return true;
      }
      function togglePassword() {
            const passwordInput = document.getElementById("newPassword");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.setAttribute("data-lucide", "eye-off"); 
            } else {
                passwordInput.type = "password";
                eyeIcon.setAttribute("data-lucide", "eye"); 
            }
            
            lucide.createIcons();
        }
        
        lucide.createIcons();
    </script>
  </body>
</html>
