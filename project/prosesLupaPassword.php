<?php
session_start();
include '../server/koneksi.php';

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    $_SESSION['reset_error'] = "Email harus diisi.";
    header("Location: ../lupa_password.php");
    exit();
}

// FIX: pakai prepared statement (sebelumnya raw query → rentan SQL injection)
$stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    $_SESSION['reset_error'] = "Email tidak terdaftar.";
    header("Location: ../lupa_password.php");
    exit();
}
$stmt->close();

// Hapus token lama untuk email ini (jika ada)
$del = $koneksi->prepare("DELETE FROM password_resets WHERE email = ?");
$del->bind_param("s", $email);
$del->execute();
$del->close();

// Buat token unik
$token   = bin2hex(random_bytes(32));
$expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Simpan token ke database
$ins = $koneksi->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
$ins->bind_param("sss", $email, $token, $expires);

if ($ins->execute()) {
    // SIMULASI: tampilkan link reset langsung di halaman (tanpa email)
    $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'], 2) . "/reset_password.php?token=" . $token;
    $_SESSION['reset_success'] = "Link reset telah dibuat. Klik link berikut untuk reset password (simulasi): <br><a href='$reset_link' target='_blank'>$reset_link</a>";
    header("Location: ../lupa_password.php");
} else {
    $_SESSION['reset_error'] = "Gagal memproses permintaan. Silakan coba lagi.";
    header("Location: ../lupa_password.php");
}
$ins->close();
exit();
?>
