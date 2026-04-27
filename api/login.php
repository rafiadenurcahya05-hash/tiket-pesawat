<?php
session_start();
// Jika sudah login, arahkan ke beranda
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Daftar | Jelajahin.Ind</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .glass-input {
            width: 100%;
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            color: white;
            font-weight: 600;
        }
        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: #f39c12;
            box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.2);
            transform: translateY(-2px);
        }
        .glass-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }
        .toast {
            visibility: hidden;
            min-width: 300px;
            background: rgba(43, 108, 148, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            text-align: center;
            border-radius: 50px;
            padding: 18px 24px;
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translate(-50%, 20px);
            z-index: 999;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-weight: 600;
            font-size: 1.1rem;
        }
        .toast.show {
            visibility: visible;
            opacity: 1;
            transform: translate(-50%, 0);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-[url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&q=80')] bg-cover bg-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
    
    <div class="relative z-10 w-full max-w-md">
        <div class="bg-white/10 backdrop-blur-lg border border-white/30 shadow-2xl rounded-[2rem] overflow-hidden p-10">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/30">
                    <i class="fas fa-plane-departure text-3xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                <p class="text-gray-200">Masuk untuk melanjutkan perjalananmu.</p>
            </div>

            <form id="authForm" action="proses/login.php" method="POST">
                <div class="space-y-5">
                    <div>
                        <label class="block text-white text-sm font-semibold mb-2">Alamat Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-orange-500 outline-none transition-all" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-white text-sm font-semibold mb-2">Kata Sandi</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-orange-500 outline-none transition-all" placeholder="••••••••">
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-6 mb-6">
                    <label class="flex items-center text-white text-sm cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-orange-500 rounded mr-2"> Ingat Saya
                    </label>
                    <a href="lupa_password.php" class="text-sm text-orange-400 font-bold hover:underline">Lupa Sandi?</a>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:scale-[1.02] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-orange-500/30">
                    Masuk Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 text-center border-t border-white/20 pt-6">
                <p class="text-gray-200">
                    Belum punya akun? 
                    <a href="register.php" class="text-orange-400 font-bold hover:underline ml-1">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>