<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Flowers.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@heroicons/web@2.0.18/24/outline/index.js" type="module"></script>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 font-['Inter']">
    
    <div class="bg-white w-full max-w-4xl rounded-[2.5rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]">
        
        <div class="md:w-1/2 relative hidden md:block">
            <img src="images/PinkRoseBouquet.jpg" alt="Login Background" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-pink-900/10"></div>
            <div class="absolute bottom-12 left-10 text-white z-10">
                <h2 class="text-4xl font-serif italic mb-2">Flowers Your Moment</h2>
                <p class="text-sm opacity-90 leading-relaxed max-w-xs">
                    Karena setiap momen spesial pantas dirayakan dengan bunga terbaik.
                </p>
            </div>
        </div>

        <div class="md:w-1/2 p-10 lg:p-16 flex flex-col justify-center bg-white">
            <div class="mb-10">
                <h1 class="text-3xl font-serif italic text-slate-800">Masuk Akun</h1>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed">
                    Selamat datang kembali! Silakan masuk ke komunitas Flowers.co.
                </p>
            </div>

            <form action="login_process.php" method="POST" class="space-y-5" onsubmit="return validateForm()">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email" 
                        placeholder="Masukkan email Anda"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
                        required
                    />
                    <p id="emailError" class="text-[10px] text-red-500 mt-1 italic"></p>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Password</label>
                        <a href="Forgot-password.php" class="text-[10px] text-pink-400 font-bold hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
                            required
                        />
                        <button type="button" onclick="togglePasswordUI()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.414 9.052 7.218 7 12 7s8.586 2.052 9.964 4.678a1.012 1.012 0 010 .644C20.586 14.948 16.782 17 12 17s-8.586-2.052-9.964-4.678z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <p id="passwordError" class="text-[10px] text-red-500 mt-1 italic"></p>
                </div>

                <button
                    type="submit"
                    name="login"
                    class="w-full py-4 bg-[#d63384] text-white rounded-xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-700 transition transform active:scale-95 mt-4"
                >
                    Masuk Sekarang
                </button>
            </form>

            <p class="text-center mt-8 text-xs text-gray-500">
                Belum punya akun?
                <a href="Register.php" class="text-[#d63384] font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

    <script>
        function togglePasswordUI() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.add("text-pink-500");
            } else {
                input.type = "password";
                icon.classList.remove("text-pink-500");
            }
        }

        // fungsi validasi akun dengan PHP
        function validateForm() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const emailError = document.getElementById("emailError");
            const passwordError = document.getElementById("passwordError");

            emailError.innerHTML = "";
            passwordError.innerHTML = "";

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.innerHTML = "Format email tidak valid!";
                return false;
            }

            if (password.length < 1) {
                passwordError.innerHTML = "Password wajib diisi!";
                return false;
            }

            return true; 
        }
    </script>
</body>
</html>