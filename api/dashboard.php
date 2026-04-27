<?php
session_start();
// Simulasi login sementara jika ingin testing tanpa login.php
// $_SESSION['username'] = "Asisten Dosen"; 

if (!isset($_SESSION['username'])) {
    header("Location: prosesLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Interactive</title>
    <style>
        :root {
            --bg-color: #f4f7f6;
            --text-color: #2c3e50;
            --card-bg: #ffffff;
            --nav-bg: #2c3e50;
            --nav-text: #ffffff;
            --shadow: rgba(0,0,0,0.1);
        }

        body.dark-mode {
            --bg-color: #1a1a2e;
            --text-color: #e0e0e0;
            --card-bg: #16213e;
            --nav-bg: #0f3460;
            --shadow: rgba(0,0,0,0.5);
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: var(--bg-color); 
            color: var(--text-color);
            transition: background-color 0.4s ease, color 0.4s ease;
        }
        
        .navbar {
            background: var(--nav-bg);
            color: var(--nav-text);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px var(--shadow);
            transition: background 0.4s ease;
        }

        .user-section { display: flex; align-items: center; gap: 20px; }
        
        .btn-action {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-darkmode { background: #f39c12; color: white; }
        .btn-darkmode:hover { background: #e67e22; }

        .btn-logout { background: #e74c3c; color: white; }
        .btn-logout:hover { background: #c0392b; }

        .container { 
            padding: 50px 20px; 
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        
        .card {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px var(--shadow);
            transition: transform 0.3s ease, background-color 0.4s ease;
            width: 100%;
            max-width: 500px;
        }

        .card:hover { transform: translateY(-5px); }

        #clock { 
            font-size: 3.5rem; 
            font-weight: 800; 
            background: linear-gradient(45deg, #3498db, #8e44ad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 15px 0; 
        }

        #greeting { font-size: 1.5rem; font-weight: 600; }
        
        #quote-container {
            margin-top: 20px;
            font-style: italic;
            color: #7f8c8d;
            font-size: 1rem;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 30px var(--shadow);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
            max-width: 400px;
            width: 90%;
        }

        .modal-overlay.show .modal-box {
            transform: translateY(0);
        }

        .modal-box h3 { margin-top: 0; color: var(--text-color); font-size: 1.5rem; }
        .modal-box p { color: #7f8c8d; margin-bottom: 25px; line-height: 1.5; }
        
        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-cancel { background: #95a5a6; color: white; }
        .btn-cancel:hover { background: #7f8c8d; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-[#1e3c5c] text-white px-8 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center gap-2">
            <i class="fas fa-compass text-orange-400 text-2xl"></i>
            <span class="text-xl font-bold tracking-tight">Jelajah<span class="text-orange-400">.In</span></span>
        </div>
        <div class="flex items-center gap-6">
            <span class="hidden md:block text-slate-300">Halo, <strong class="text-white"><?= $_SESSION['nama'] ?></strong></span>
            <a href="logout.php" class="bg-red-500/20 hover:bg-red-500 px-4 py-2 rounded-lg text-sm font-bold transition-all border border-red-500/50">Logout</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800">Destinasi Populer ✨</h2>
                <p class="text-slate-500">Temukan tempat impian untuk liburan Anda berikutnya.</p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 bg-white rounded-lg shadow-sm border border-slate-200 hover:bg-slate-100"><i class="fas fa-filter"></i></button>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php while($row = mysqli_fetch_assoc($query)): ?>
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="relative h-56 overflow-hidden">
                    <img src="<?= $row['imgUrl'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/600x400'">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-orange-600">
                        ⭐ <?= $row['rating'] ?>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-1 line-clamp-1"><?= $row['nama'] ?></h3>
                    <p class="text-slate-400 text-sm flex items-center gap-1 mb-4">
                        <i class="fas fa-map-marker-alt text-orange-500"></i> <?= $row['lokasi'] ?>
                    </p>
                    <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Harga Tiket</p>
                            <p class="text-lg font-bold text-[#1e3c5c]">Rp <?= number_format($row['harga'],0,',','.') ?></p>
                        </div>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-2xl transition-colors shadow-lg shadow-orange-500/20">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>