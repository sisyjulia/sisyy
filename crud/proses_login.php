<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 sesuai dengan sistem tambah data

    // Mencari user berdasarkan username ATAU email
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Menyimpan data ke session
        $_SESSION['user_id']  = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];
        $_SESSION['nama']     = $data['nama']; // <-- Kunci agar index.php tidak error lagi!

        echo "<script>alert('Selamat datang, pendekar! 🙏✨'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Aduh, username atau password kamu salah! 🥺'); window.location='login.php';</script>";
    }
} else {
    header("location:login.php");
}
?>