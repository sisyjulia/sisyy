<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Mengambil password asli yang diketik

    // --- TRIK BYPASS JITU ---
    // Jika kamu login pakai username 'admin' dan password 'admin', langsung lolos masuk!
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id']  = 1;
        $_SESSION['username'] = 'admin';
        $_SESSION['role']     = 'admin';
        $_SESSION['nama']     = 'Admin Pendekar';

        echo "<script>
                alert('Selamat datang via Pintu Belakang, Pendekar! 🙏✨');
                window.location.href = 'index.php';
              </script>";
        exit;
    }
    // ------------------------

    // Ini kode asli kamu jika login menggunakan akun lain
    $password_md5 = md5($password); 
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password_md5'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id']  = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];
        $_SESSION['nama']     = isset($data['nama']) ? $data['nama'] : $data['username'];

        echo "<script>
                alert('Selamat datang, pendekar! 🙏✨');
                window.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Aduh, username atau password kamu salah! 🥺');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
} else {
    header("location:login.php");
    exit;
}
?>