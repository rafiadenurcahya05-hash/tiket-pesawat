<?php
session_start();
include 'server/koneksi.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Token tidak valid.");
}

// FIX: pakai prepared statement (sebelumnya raw query → rentan SQL injection)
$stmt = $koneksi->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Token sudah kadaluwarsa atau tidak valid.");
}

$reset = $result->fetch_assoc();
$email = $reset['email'];
$stmt->close();

// Proses reset password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'];
    $confirm      = $_POST['confirm_password'];

    if ($new_password !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok.";
    } elseif (strlen($new_password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // FIX: pakai prepared statement untuk update
        $upd = $koneksi->prepare("UPDATE users SET password = ? WHERE email = ?");
        $upd->bind_param("ss", $hashed, $email);

        if ($upd->execute()) {
            // Hapus token yang sudah digunakan
            $del = $koneksi->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param("s", $email);
            $del->execute();
            $del->close();

            $_SESSION['reset_success'] = "Password berhasil diubah. Silakan login.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal mengupdate password.";
        }
        $upd->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | DDELTIKET</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 m-4">
        <h2 class="text-2xl font-bold text-center text-[#1e3c5c] mb-6">Buat Password Baru</h2>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password Baru</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="confirm_password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button type="submit" class="w-full bg-[#f39c12] hover:bg-[#e67e22] text-white font-bold py-2 rounded-lg transition">Reset Password</button>
        </form>
    </div>
</body>
</html>
