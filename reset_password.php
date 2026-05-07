<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Flowers.co</title>
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
    </style>
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div
        class="bg-white w-full max-w-4xl rounded-[3rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[600px]">

        <div class="md:w-1/2 relative hidden md:block">
            <img src="images/PinkRoseBouquet.jpg" alt="Reset Password Background"
                class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-pink-900/20"></div>
            <div class="absolute bottom-12 left-10 text-white z-10">
                <h2 class="text-4xl font-serif italic mb-2">Flowers Your Moment</h2>
                <p class="text-sm opacity-90 leading-relaxed max-w-xs">
                    Buatlah password baru yang kuat agar akun Anda tetap aman dan terlindungi.
                </p>
            </div>
        </div>

        <div class="md:w-1/2 p-10 lg:p-16 flex flex-col justify-center bg-white relative">
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-serif italic text-slate-800">Pulihkan Akun</h1>
                    <p class="text-gray-400 text-sm mt-2 leading-relaxed">
                        Masukkan email Anda dan buat password baru untuk memulihkan akses.
                    </p>
                </div>

                <form action="reset_password_process.php" method="POST" class="space-y-5">
                    <?php $email = isset($_GET['email']) ? $_GET['email'] : ''; ?>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email
                            Terdaftar</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-100 rounded-xl outline-none text-gray-500 text-sm cursor-not-allowed" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Password
                            Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="passwordInput"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none focus:ring-2 focus:ring-pink-200 transition text-sm"
                                required minlength="8" />
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#d63384]">
                                <i id="eyeIcon" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="reset"
                        class="w-full py-4 bg-[#d63384] text-white rounded-xl font-bold shadow-lg shadow-pink-100 hover:bg-pink-700 transition transform active:scale-95">
                        Update Password
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="Login.php" class="text-xs text-gray-400 hover:text-pink-500 font-medium transition">
                        Kembali ke Halaman Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>

</html>