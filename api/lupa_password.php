<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Sandi | DDELTIKET</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #f0f5fa; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200 w-full max-w-md p-10 border border-slate-100">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl mb-4">
                <i class="fas fa-key text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Lupa Sandi?</h1>
            <p class="text-slate-500 mt-2">Kami akan mengirimkan instruksi reset ke email Anda.</p>
        </div>

        <!-- Alert PHP Logic -->
        <?php if (isset($_SESSION['reset_error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl text-sm">
                <?= $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?>
            </div>
        <?php endif; ?>

        <form action="proses/prosesLupaPassword.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-slate-700 font-bold mb-2 text-sm">Alamat Email Terdaftar</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
            </div>
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-orange-500/20">
                Kirim Link Reset
            </button>
        </form>

        <div class="text-center mt-8">
            <a href="login.php" class="text-slate-500 hover:text-orange-500 text-sm font-semibold transition flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Login
            </a>
        </div>
    </div>
</body>
</html>